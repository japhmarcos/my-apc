<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;

use App\Post as Post;
use App\Event as Event;
use Auth;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home.index');
	}

	public function bus()
	{
		return view('home.bus');
	}

	public function directory()
	{
		return view('home.directory');
	}

	public function account()
	{
		return view('home.account');
	}

	public function applications()
	{
		return view('home.applications');
	}

	public function search()
	{
		$input = Input::get('input');
		if(Auth::guest())
		{
			$posts = Post::where('status', '=', '1')->where('module_id', '!=', '2')->where(function($query) use ($input){
					$query->where('title', 'LIKE', '%'.$input.'%');
					$query->orWhere('body', 'LIKE', '%'.$input.'%');
					$query->orWhere('author', 'LIKE', '%'.$input.'%');
				})->orderBy('created_at', 'desc')->get();
		}
		else
		{
			$posts = Post::where('status', '=', '1')->where(function($query) use ($input){
					$query->where('title', 'LIKE', '%'.$input.'%');
					$query->orWhere('body', 'LIKE', '%'.$input.'%');
					$query->orWhere('author', 'LIKE', '%'.$input.'%');
				})->orderBy('created_at', 'desc')->get();
		}
		
		$events = Event::where('status', '=', '1')->where(function($query) use ($input){
				$query->where('title', 'LIKE', '%'.$input.'%');
				$query->orWhere('body', 'LIKE', '%'.$input.'%');
			})->orderBy('created_at', 'desc')->get();
		
		
		return view('home.search', compact('posts', 'events', 'input'));
	}

}
