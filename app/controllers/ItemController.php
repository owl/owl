<?php

class ItemController extends BaseController{

    public function create($templateId = null){
        $user = Sentry::getUser();
        $user_items = Item::with('user')
                    ->where('published', '2')
                    ->where('user_id', $user->id)
                    ->orderBy('id','desc')
                    ->take(5)->get();

        if(!Input::get('t')) {
            return View::make('items.create', compact('template', 'user_items'));
        }

        $templateId = Input::get('t');
        $template = Template::where('id',$templateId)->first();
        return View::make('items.create', compact('template', 'user_items'));
    }

    public function store(){
        // バリデーションルールの作成
        $valid_rule = array(
            'title' => 'required|max:255',
            'body' => 'required',
            'published' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = Sentry::getUser();
        $item = new Item;
        $item->fill(array(
            'user_id'=>$user->id,
            'open_item_id' => Item::createOpenItemId(),
            'title'=>Input::get('title'),
            'body'=>str_replace('<', '&lt;', Input::get('body')),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::to('/'); 
    }

    public function index(){
        $items = Item::with('user')
                    ->where('published', '2')
                    ->orderBy('id','desc')
                    ->paginate(10);
        $templates = Template::all();
        return View::make('items.index', compact('items', 'templates'));
    }

    public function show($openItemId){
        $user = Sentry::getUser();

        if(empty($user)){
            return $this->notLoginShow($openItemId);
        }

        $item = Item::with('comment.user')->where('open_item_id',$openItemId)->first();

        if (empty($item)){
            App::abort(404);
        }
        if ($item->published === '0' && $item->user_id !== $user->id){
            App::abort(404);
        }

        $like_users = Item::with('like.user')
                        ->where('id', $item->id)
                        ->first();

        // Markdown Parse
        $parser = new CustomMarkdown;
        $parser->enableNewlines = true;
        $item->body = $parser->parse($item->body);

        $stock = Stock::whereRaw('user_id = ? and item_id = ?', array($user->id, $item->id))->get();
        $like = Like::whereRaw('user_id = ? and item_id = ?', array($user->id, $item->id))->get();

        $user_items = Item::with('user')
                    ->where('published', '2')
                    ->where('user_id', $item->user_id)
                    ->orderBy('id','desc')
                    ->take(5)->get();
        return View::make('items.show', compact('item', 'user_items', 'stock', 'like', 'like_users'));
    }

    public function edit($openItemId){
        $user = Sentry::getUser();
        $user_items = Item::with('user')
                    ->where('published', '2')
                    ->where('user_id', $user->id)
                    ->orderBy('id','desc')
                    ->take(5)->get();

        $item = Item::where('open_item_id',$openItemId)->first();

        if ($item->user_id !== $user->id){
            App::abort(404);
        }

        if ($item == null){
            App::abort(404);
        }
        $templates = Template::all();
        return View::make('items.edit', compact('item', 'templates', 'user_items'));
    }

    public function update($openItemId){
        // バリデーションルールの作成
        $valid_rule = array(
            'title' => 'required|max:255',
            'body' => 'required',
            'published' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $valid_rule);

        // 失敗の場合
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = Sentry::getUser();
        $item = Item::where('open_item_id',$openItemId)->first();;

        if ($item->user_id !== $user->id){
            App::abort(404);
        }

        if ($item == null){
            App::abort(404);
        }
        $item->fill(array(
            'user_id'=>$user->id,
            'title'=>Input::get('title'),
            'body'=>str_replace('<', '&lt;', Input::get('body')),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::route('items.show',[$openItemId]);
    }

    public function destroy($openItemId){
        $user = Sentry::getUser();
        $item = Item::where('open_item_id',$openItemId)->first();;

        if ($item->user_id !== $user->id){
            App::abort(404);
        }

        if ($item == null){
            App::abort(404);
        }
        Item::where('open_item_id',$openItemId)->delete();
        return Redirect::route('items.index');
    }

    public function notLoginShow($openItemId){
        $item = Item::with('comment.user')->where('open_item_id',$openItemId)->first();

        if (empty($item)){
            App::abort(404);
        }
        if ($item->published !== '2'){
            App::abort(404);
        }

        $like_users = Item::with('like.user')
                        ->where('id', $item->id)
                        ->first();

        // Markdown Parse
        $parser = new CustomMarkdown;
        $parser->enableNewlines = true;
        $item->body = $parser->parse($item->body);

        $user_items = Item::with('user')
                    ->where('published', '2')
                    ->where('user_id', $item->user_id)
                    ->orderBy('id','desc')
                    ->take(5)->get();
        return View::make('items.show', compact('item', 'user_items', 'like_users'));
    }


}
