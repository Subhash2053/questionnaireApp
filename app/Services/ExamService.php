<?php

namespace App\Services;

use App\Enums\Role;
use App\Mail\ExamMail;
use App\Models\Exam;
use App\Models\Link;
use App\Models\Question;
use App\Models\User;
use App\Models\UserAnswer;
use Exception;
use Illuminate\Support\Facades\Mail;

class ExamService
{
    public function __construct(
        private Exam $exam,
        private Question $question,
        private User $user,
        private Link $link,
        private UserAnswer $userAnswer
    ) {

    }

    /**
     * Get active Exam List
     * @return mixed
     */
    public function activeExamsList()
    {
        return $this->exam->active()->get();
    }

    /**
     * Store Exam
     * @param array $data
     * @return mixed
     */
    public function storeExam($data)
    {
        $randomPhysicsQuestionIds = $this->generateRandomQuestion('Physics');
        $randomChemistryQuestionIds = $this->generateRandomQuestion('Chemistry');

        $combinedRandomQuestionIds = array_merge($randomChemistryQuestionIds, $randomPhysicsQuestionIds);
        $examCreated = $this->exam->create($data);
        if($examCreated) {
            $examCreated->questions()->sync($combinedRandomQuestionIds);
        }
        return $examCreated;

    }

    /**
     * Send mail with exam link to all students
     * @param  Exam $exam
     * @return void
     */
    public function sendExamMail($exam)
    {
        $users= $this->user->where('role_id', Role::Student)->get();

        foreach($users as $user) {
            Mail::to($user->email)->send(new ExamMail($exam, $user));
        }

    }

    /**
    * Save Questionare answer submitted by student
    * @param  array $data
    * @param  User $user
    * @param  Exam $exam
    * @return void
    */
    public function saveExam($data, $user, $exam)
    {

        $linkQuery = $this->link->where('exam_id', $exam->id)->where('user_id', $user->id);

        if(!$linkQuery->exists()) {
            throw new Exception('Link expired');
        }

        foreach($data as $question_id=>$answer_id) {
            $user->answers()->updateOrCreate([
                'question_id'=>$question_id,
                'exam_id'=>$exam->id
            ], [
                'question_id'=>$question_id,
                'option_id'=>$answer_id,
                'exam_id'=>$exam->id
            ]);
        }


        $linkQuery->delete();

    }

    /**
    * Get questions(Physics ans chemistry) of given Exam
    * @param  Exam $exam
    * @return mixed
    */
    public function getQuestions($exam)
    {
        $questions['Physics'] = $exam->questions()->where('subject', 'Physics')->with('options')->get();
        $questions['Chemistry'] = $exam->questions()->where('subject', 'Chemistry')->with('options')->get();
        return $questions;
    }

    /**
    * Generate Random question for given subject
    * @param  string $subject
    * @return array
    */
    public function generateRandomQuestion($subject)
    {
        return $this->question->where('subject', $subject)->inRandomOrder()
         ->limit(5)->pluck('id')->toArray();

    }

    /**
    * Decode Token
    * @param  string $token
    * @return array
    */
    public function decodeToken($token)
    {
        $decodedToken = json_decode(base64_decode($token), true);

        $email = $decodedToken['email'];
        $exam_id= $decodedToken['exam_id'];

        $exam = $this->exam->active()->find($exam_id);

        $user = $this->user->where('email', $email)->first();

        if(!$exam || !$user) {
            throw new Exception('Url Not working');
        }

        $linkQuery = $this->link->where('exam_id', $exam->id)->where('user_id', $user->id);

        if(!$linkQuery->exists()) {
            throw new Exception('Link expired');
        }
        return ['exam'=>$exam,
        'user'=>$user
    ];

    }
}
