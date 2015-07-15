<?php namespace Owl\Http\Controllers;

use Owl\Services\UserService;
use Owl\Services\TagService;
use Owl\Repositories\ItemRepositoryInterface;
use Owl\Repositories\ItemHistoryRepositoryInterface;
use Owl\Repositories\LikeRepositoryInterface;
use Owl\Repositories\StockRepositoryInterface;
use Owl\Repositories\TemplateRepositoryInterface;

class ItemController extends Controller
{
    protected $userService;
    protected $tagService;
    protected $itemRepo;
    protected $itemHistoryRepo;
    protected $likeRepo;
    protected $stockRepo;
    protected $templateRepo;

    public function __construct(
        UserService $userService,
        tagService $tagService,
        ItemRepositoryInterface $itemRepo,
        ItemHistoryRepositoryInterface $itemHistoryRepo,
        LikeRepositoryInterface $likeRepo,
        StockRepositoryInterface $stockRepo,
        TemplateRepositoryInterface $templateRepo
    ) {
        $this->userService = $userService;
        $this->tagService = $tagService;
        $this->itemRepo = $itemRepo;
        $this->itemHistoryRepo = $itemHistoryRepo;
        $this->likeRepo = $likeRepo;
        $this->stockRepo = $stockRepo;
        $this->templateRepo = $templateRepo;
    }

    public function create($templateId = null)
    {
        $user = $this->userService->getCurrentUser();
        $user_items = $this->itemRepo->getRecentsByUserId($user->id);
        $template = null;
        if (\Input::get('t')) {
            $templateId = \Input::get('t');
            $template = $this->templateRepo->getById($templateId);
        }
        return \View::make('items.create', compact('template', 'user_items'));
    }

    public function store()
    {
        $valid_rule = array(
            'title' => 'required|max:255',
            'tags' => 'alpha_comma|max:64',
            'body' => 'required',
            'published' => 'required|numeric'
        );
        $validator = \Validator::make(\Input::all(), $valid_rule);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $user = $this->userService->getCurrentUser();

        $object = app('stdClass');
        $object->user_id = $user->id;
        $object->open_item_id = $this->itemRepo->createOpenItemId();
        $object->title = \Input::get('title');
        $object->body = \Input::get('body');
        $object->published = \Input::get('published');
        $item = $this->itemRepo->create($object);

        $result = $this->itemHistoryRepo->create($item, $user);

        $tags = \Input::get('tags');
        if (!empty($tags)) {
            $tag_names = explode(",", $tags);
            $tag_ids = $this->tagService->getTagIdsByTagNames($tag_names);
            $item = $this->itemRepo->getById($item->id);
            $item->tag()->sync($tag_ids);
        }

        return \Redirect::route('items.show', [$item->openItemId]);
    }

    public function index()
    {
        $items = $this->itemRepo->getAllPublished();
        $templates = $this->templateRepo->getAll();
        return \View::make('items.index', compact('items', 'templates'));
    }

    public function show($openItemId)
    {
        $item = $this->itemRepo->getByOpenItemIdWithComment($openItemId);
        if (empty($item)) {
            \App::abort(404);
        }

        $user = $this->userService->getCurrentUser();
        if ($item->published === "0") {
            if (empty($user)) {
                \App::abort(404);
            } elseif ($item->user_id !== $user->id) {
                \App::abort(404);
            }
        }

        $stock = null;
        $like = null;
        if (!empty($user)) {
            $stock = $this->stockRepo->getByUserIdAndItemId($user->id, $item->id);
            $like = $this->likeRepo->get($user->id, $item->id);
        }
        $stocks = $this->stockRepo->getByItemId($item->id);
        $recent_stocks = $this->stockRepo->getRecentRankingWithCache(5, 7);
        $user_items = $this->itemRepo->getRecentsByUserId($item->user_id);
        $like_users = $this->itemRepo->getLikeUsersById($item->id);
        return \View::make('items.show', compact('item', 'user_items', 'stock', 'like', 'like_users', 'stocks', 'recent_stocks'));
    }

    public function edit($openItemId)
    {
        $user = $this->userService->getCurrentUser();
        $item = $this->itemRepo->getByOpenItemId($openItemId);
        if ($item === null) {
            \App::abort(404);
        }

        $templates = $this->templateRepo->getAll();
        $user_items = $this->itemRepo->getRecentsByUserId($user->id);
        return \View::make('items.edit', compact('item', 'templates', 'user_items'));
    }

    public function update($openItemId)
    {
        $valid_rule = array(
            'title' => 'required|max:255',
            'tags' => 'alpha_comma|max:64',
            'body' => 'required',
            'published' => 'required|numeric'
        );
        $validator = \Validator::make(\Input::all(), $valid_rule);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $user = $this->userService->getCurrentUser();
        $item = $this->itemRepo->getByOpenItemId($openItemId);
        if ($item == null) {
            \App::abort(404);
        }

        $user_id = $user->id;
        if ($item->user_id !== $user->id) {
            $user_id = $item->user_id;
        }

        $object = app('stdClass');
        $object->user_id = $user_id;
        $object->title = \Input::get('title');
        $object->body = \Input::get('body');
        $object->published = \Input::get('published');
        $item = $this->itemRepo->update($item->id, $object);

        $result = $this->itemHistoryRepo->create($item, $user);

        $tags = \Input::get('tags');
        if (!empty($tags)) {
            $tag_names = explode(",", $tags);
            $tag_ids = $this->tagService->getTagIdsByTagNames($tag_names);
            $item = $this->itemRepo->getById($item->id);
            $item->tag()->sync($tag_ids);
        }

        return \Redirect::route('items.show', [$openItemId]);
    }

    public function destroy($openItemId)
    {
        $user = $this->userService->getCurrentUser();
        $item = $this->itemRepo->getByOpenItemId($openItemId);
        if ($item == null || $item->user_id !== $user->id) {
            \App::abort(404);
        }
        $this->itemRepo->delete($item->id);
        $no_tag = array();
        $item->tag()->sync($no_tag);

        return \Redirect::route('items.index');
    }

    public function history($openItemId)
    {
        $histories = $this->itemHistoryRepo->getByOpenItemId($openItemId);
        return \View::make('items.history', compact('histories'));
    }
}
