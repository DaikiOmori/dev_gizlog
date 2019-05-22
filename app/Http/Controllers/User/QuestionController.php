<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionsRequest;
use App\Http\Requests\User\CommentRequest;
use App\Models\User;
use App\Models\Question;
use App\Models\Comment;
use App\Models\TagCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

const MAX_PAGE_COUNT = 30;


class QuestionController extends Controller
{
    protected $question;
    protected $comment;
    protected $category;

    public function __construct(Question $question, Comment $comment, TagCategory $category)
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->comment = $comment;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $inputs = $request->all();
        $categories = $this->category->all();
        if (array_key_exists('search_word', $inputs)) {
            $questions = $this->question->searchWord($inputs)->paginate(MAX_PAGE_COUNT);
        } else {
            $questions = $this->question->orderby('created_at', 'desc')->paginate(MAX_PAGE_COUNT);
        }
        return view('user.question.index', compact('categories','questions','inputs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = $this->category->all();
        return view('user.question.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        //
        $inputs = $request->all();
        $this->question->create($inputs)->save();
        return redirect()->route('question.index');
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
        $question = $this->question->find($id);
        return view('user.question.show', compact('question'));
    }

    public function myPage($userId)
    {
        //
        $questions = $this->question->where('user_id', $userId)->orderby('created_at', 'desc')->get();
        return view('user.question.mypage', compact('questions'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories = $this->category->all();
        $question = $this->question->find($id);
        return view('user.question.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionsRequest $request, $questionId)
    {
        // 
        $inputs = $request->all();
        $this->question->find($questionId)->fill($inputs)->save();
        return redirect()->route('question.index');
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
        $question = $this->question->find($id)->delete();
        return redirect()->route('question.index');
    }

    public function comment(CommentRequest $request)
    {
        //
        $inputs = $request->all();
        $this->comment->create($inputs)->save();
        return redirect()->route('question.index');
    }
}
