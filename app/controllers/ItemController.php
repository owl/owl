<?php

class ItemController extends BaseController{

    public function create($templateId = null){
        if(!Input::get('t')) {
            return View::make('items.create', compact('template'));
        }

        $templateId = Input::get('t');
        $template = Template::where('id',$templateId)->first();
        return View::make('items.create', compact('template'));
    }

    public function store(){
        $user = Sentry::getUser();
        $item = new Item;
        $item->fill(array(
            'user_id'=>$user->id,
            'open_item_id' => $this->createOpenItemId(),
            'title'=>Input::get('title'),
            'body'=>Input::get('body'),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::to('/'); 
    }

    private function createOpenItemId(){
        return substr(md5(uniqid(rand(),1)),0,20);
    }

    public function index(){
        $items = Item::with('user')
                    ->orderBy('id','desc')
                    ->paginate(10);
        $templates = Template::all();
        return View::make('items.index', compact('items', 'templates'));
    }

    public function show($openItemId){
        $user = Sentry::getUser();

        $item = Item::where('open_item_id',$openItemId)->first();
        if ($item == null){
            App::abort(404);
        }

        // Markdown Parse
        $parser = new CustomMarkdown;
        $parser->enableNewlines = true;
        $item->body = $parser->parse($item->body);

        $templates = Template::all();

        $stock = Stock::whereRaw('user_id = ? and item_id = ?', array($user->id, $item->id))
                      ->get();

        return View::make('items.show', compact('item', 'templates', 'stock'));
    }

    public function edit($openItemId){
        $item = Item::where('open_item_id',$openItemId)->first();
        if ($item == null){
            App::abort(404);
        }
        $templates = Template::all();
        return View::make('items.edit', compact('item', 'templates'));
    }

    public function update($openItemId){
        $user = Sentry::getUser();
        $item = Item::where('open_item_id',$openItemId)->first();;
        if ($item == null){
            App::abort(404);
        }
        $item->fill(array(
            'user_id'=>$user->id,
            'title'=>Input::get('title'),
            'body'=>htmlspecialchars(Input::get('body'), ENT_QUOTES, 'UTF-8'),
            'published'=>Input::get('published')
        ));
        $item->save();
        return Redirect::route('items.show',[$openItemId]);
    }

    public function destroy($openItemId){
        Item::where('open_item_id',$openItemId)->delete();
        return Redirect::route('items.index');
    }
}
