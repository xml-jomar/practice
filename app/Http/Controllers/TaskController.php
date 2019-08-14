<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        // return view('tasks.index');
        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task([
            'name' => $request->get('name'),
            'desc'=> $request->get('desc')
        ]);
        $task->save();
        
        return redirect('/tasks')->with('success', 'Task has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sel = Task::whereId($id)->first();
        $tasks = Task::all();
        // echo var_dump($sel);
        $query = $tasks->toArray();
        echo var_dump($query);
        // $res = json_decode(json_encode($query), true);

        $xmlobj = new \SimpleXMLElement("<root></root>");
        // echo $this->convert($query,$xmlobj);

        $xml = new \SimpleXMLElement('<root/>');
        array_walk_recursive($query, array ($xml, 'addChild'));
        print $xml->asXML();

        return view('tasks.index', ['tasks' => $tasks, 'sel' => $sel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 
     */
    public function convert($array, $xml){
        foreach($array  as $key=>$line){
            if(!is_array($line)){
                $data = $xml->addChild($key, $line);

            }else{
                $obj = $xml->addChild($key);

                if(!empty($line['attribute'])){

                    $attr = explode(":",$line['attribute']);
                    $obj->addAttribute($attr[0],$attr[1]);
                    unset($line['attribute']);
                }
                $this->convert($line, $obj);
            }
        }

        echo 'test'.$xml;
        return $xml;
    }
}
