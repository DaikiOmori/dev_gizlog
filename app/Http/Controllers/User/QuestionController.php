<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Http\Requests\User\QuestionsRequest;
use App\Models\Comment;
use App\Models\Question;
use App\Models\TagCategory;
use Illuminate\Http\Request;

const MAX_PAGE_COUNT = 30;

class QuestionController extends Controller
{
    protected $question;
    protected $category;
    protected $comment;

    public function __construct(Question $question, TagCategory $category, Comment $comment) //使うdbモデルのインスタンス化
    {
        $this->middleware('auth');
        $this->question = $question;
        $this->category = $category;
        $this->comment = $comment;
    }

    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function index(Request $request)
    {
        $categories = $this->category->all();
        $inputs = $request->all();
        if (array_key_exists('search_word', $inputs)) {
            $questions = $this->question->fetchSearchingQuestion($inputs)->paginate(MAX_PAGE_COUNT);
        } else {
            $questions = $this->question->orderby('created_at', 'desc')->paginate(MAX_PAGE_COUNT);
        }
        return view('user.question.index', compact('questions', 'categories', 'inputs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->category->all();
        return view('user.question.create', compact('categories'));
    }

    /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $this->question->create($inputs);
        return redirect()->route('question.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $question = $this->question->find($id);
        return view('user.question.show', compact('question'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $categories = $this->category->all();
        $question = $this->question->find($id);
        return view('user.question.edit', compact('question', 'categories'));
    }

    /**
     * @param QuestionsRequest $request
     * @param $questionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionsRequest $request, $questionId)
    {
        $inputs = $request->all();
        $this->question->find($questionId)->fill($inputs)->save();
        return redirect()->route('question.index');
    }

    /**
     * @param $questionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($questionId)
    {
        $this->question->find($questionId)->delete();
        return redirect()->route('question.index');
    }

    /**
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myPage($userId)
    {
        $questions = $this->question->fetchMyPageQuestions($userId);
        return view('user.question.mypage', compact('questions'));
    }

    /**
     * @param QuestionsRequest $request
     * @param null $questionId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(QuestionsRequest $request, $questionId = null)
    {
        $inputs = $request->all();
        $category = $this->category->find($inputs['tag_category_id'])->name;
        return view('user.question.confirm', compact('inputs', 'category', 'questionId'));
    }

    /**
     * @param CommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(CommentRequest $request)
    {
        $inputs = $request->all();
        $this->comment->create($inputs);
        return redirect()->route('question.index');
    }

}