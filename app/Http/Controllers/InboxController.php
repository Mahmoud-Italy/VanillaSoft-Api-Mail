<?php

namespace App\Http\Controllers;

use App\Models\Inbox as Model;
use Illuminate\Http\Request;
use App\Http\Requests\InboxStoreRequest as StoreRequest;
use App\Http\Resources\InboxResource as Resource;

class InboxController extends Controller
{

    public function index()
    {
        $items = Resource::collection(Model::latest()->paginate(10));
        return response()->json([
            'items'       => $items,
            'paginate'    => $this->paginate($items)
        ], 200);
    }

    public function show($id)
    {
        $item = new Resource(Model::findOrFail(decrypt($id)));
        return response()->json([
            'item'  => $item,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $row = Model::createOrUpdate();
        if($row === true) {
            return response()->json(['message' => ''], 201);
        } else {
            return response()->json(['message' => 'Unable to create entry ' . $row], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $row = Model::query();

            if(strpos($id, ',') !== false) {
                foreach(explode(',',$id) as $sid) {
                    $ids[] = $sid;
                }
                $row->whereIN('id', $ids);
            } else {
                $row->where('id', decrypt($id));
            }   
            $row->delete();

            return response()->json(['message' => ''], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unable to delete entry, '. $e->getMessage()], 500);
        }
    }
}