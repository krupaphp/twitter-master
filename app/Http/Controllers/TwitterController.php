<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Twitter;
use File;


class TwitterController extends Controller
{
     
    
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function twitterUserTimeLine()
    {
    	$data = array();
    	return view('twitter',compact('data', 'screen_name')); 
    }
    
    public function search(Request $request) {
        
        $this->validate($request, [
        		'screen_name' => 'required'
        	]);
        $screen_name = ['screen_name' => $request->screen_name];
        
        $exploded = explode(',', $request->screen_name);
        
        
        if(count($exploded) > 2) {
           return false;
        }
        $data2 = array();
        $data1 = Twitter::getUserTimeline(['screen_name' => $exploded[0], 'count' => 3, 'format' => 'array']);
        if(isset($exploded[1]))
        $data2 = Twitter::getUserTimeline(['screen_name' => $exploded[1], 'count' => 3, 'format' => 'array']);

       //$data['screen_name'] = $screen_name;
        $data = array_merge($data1, $data2);
    	return view('twitter',compact('data', 'screen_name'));
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function tweet(Request $request)
    {
    	$this->validate($request, [
        		'tweet' => 'required'
        	]);


    	$newTwitte = ['status' => $request->tweet];

    	
    	if(!empty($request->images)){
    		foreach ($request->images as $key => $value) {
    			$uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
    			if(!empty($uploaded_media)){
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
    		}
    	}


    	$twitter = Twitter::postTweet($newTwitte);

    	
    	return back();
    }
}