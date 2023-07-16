<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamSubmitRequest;
use App\Http\Requests\StoreExamRequest;
use App\Models\Exam;
use App\Models\User;
use App\Services\ExamService;
use App\Services\UserService;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ExamController extends Controller
{
    public function __construct(
        private ExamService $examService,
        private UserService $userService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $activeExams = $this->examService->activeExamsList();

        return Inertia::render('Exam/List', [
            'exams' => $activeExams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Exam/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamRequest $request)
    {
        try {
            $this->examService->storeExam($request->validated());
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
           return redirect()
            ->back()
            ->withError($th->getMessage());
        }

        return redirect()
        ->route('exam.index')
        ->withSuccess("Questionnaire successfully created.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        dd($exam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        //
    }

    public function sendEmail(Exam $exam)
    {

        $this->examService->sendExamMail($exam);
        
        return redirect()
        ->back()
        ->withSuccess('Invitation sent successfully');
    }

    public function fillExam(Request $request, $token)
    {
        if (! $request->hasValidSignature()) {
            throw new Exception('Invalid Signature');
        }
        $decodedResponse = $this->examService->decodeToken($token);
        $questions = $this->examService->getQuestions($decodedResponse['exam']);
        return Inertia::render('Exam/Fill', [
            'questions' => $questions,
            'user' => $decodedResponse['user'],
            'exam'=>$decodedResponse['exam']
        ]);
    }


    public function submitExam(ExamSubmitRequest $request,Exam $exam)
    {
      try {
        $user=  $this->userService->checkUserCred( $request->validated());
        $data= $request->all();
        unset($data['email']);
        unset($data['password']);
        $this->examService->saveExam($data,$user,$exam);
      } catch (\Throwable $th) {
        return response()->json([
            'status'  => 500,
            'message' => $th->getMessage(),
            'data'    => null,
        ],500 );
      }
      return response()->json([
        'status'  => 200,
        'message' => 'Exam successfully Submitted',
        'data'    => $user,
    ],200 );
    }
}
