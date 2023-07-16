<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question' =>'Magnesium ribbon is rubbed before burning because it has a coating of',
                'subject'=>'Chemistry',
                'option'=>[
                    'basic magnesium carbonate'=>true,
                    'basic magnesium oxide'=>false,
                    'basic magnesium sulphide'=>false,
                    'basic magnesium chloride'=>false,
                ]
            ],
            [
                'question' =>'Oxidation is a process which involves',
                'subject'=>'Chemistry',
                'option'=>[
                    'addition of oxygen'=>true,
                    'addition of hydrogen'=>false,
                    'removal of oxygen'=>false,
                    'removal of hydrogen'=>false,
                ]
            ],

            [
                'question' =>'The process of reduction involves',
                'subject'=>'Chemistry',
                'option'=>[
                    'addition of oxygen'=>false,
                    'addition of hydrogen'=>true,
                    'removal of oxygen'=>false,
                    'removal of hydrogen'=>false,
                ]
            ],
            [
                'question' =>'Give the ratio in which hydrogen and oxygen are present in water by volume.',
                'subject'=>'Chemistry',
                'option'=>[
                    '1:2'=>true,
                    '1:1'=>false,
                    '2:1'=>false,
                    '1:8'=>false,
                ]
            ],
            [
                'question' =>'MnO2 + 4HCl → 2 + 2H2O + Cl2 . Identify the substance oxidized in the above . equation.',
                'subject'=>'Chemistry',
                'option'=>[
                    'MnCl2'=>false,
                    'HCl'=>false,
                    'H2O'=>false,
                    'MnO2'=>true,
                ]
            ],
            [
                'question' =>'A substance `X` is used in white-washing and is obtained by heating limestone in the absence of air. Identify ‘X’.',
                'subject'=>'Chemistry',
                'option'=>[
                    'CaOCl2'=>true,
                    'Ca (OH)2'=>false,
                    'CaO'=>false,
                    'CaCO3'=>false,
                ]
            ],
            [
                'question'=>'What type of chemical reactions take place when electricity is passed through water?',
                'subject'=>'Chemistry',
                'option'=>[
                    'Displacement'=>false,
                    'Combination'=>false,
                    'Decomposition'=>true,
                    'Double displacement'=>false,
                ]
                ],

                [
                    'question'=>'Which among the following temperature scale is based upon absolute zero?',
                    'subject'=>'Physics',
                    'option'=>[
                        'Celsius'=>false,
                        'Fahrenheit'=>false,
                        'Kelvin'=>true,
                        'Rankine'=>false,
                    ]
                    ],
                    [
                        'question'=>'Optical Fibre technology works on which of these principles of Physics?',
                        'subject'=>'Physics',
                        'option'=>[
                            'Bernoulli’s Principle'=>false,
                            'Newton’s law of Motion'=>false,
                            'Total internal reflection of Light'=>true,
                            'Photoelectric effect'=>false,
                        ]
                        ],
                        [
                            'question'=>'Which of the following is the unit of Solid Angle?',
                            'subject'=>'Physics',
                            'option'=>[
                                'radian'=>false,
                                'steradian'=>true,
                                'm2'=>false,
                                'π'=>false,
                            ]
                            ],

                            [
                                'question'=>'What is the slope of the velocity-time graph when an object moves with constant negative acceleration, having positive initial velocity?',
                                'subject'=>'Physics',
                                'option'=>[
                                    '90°'=>false,
                                    'more than 90°'=>true,
                                    'less than 90°'=>false,
                                    '0°'=>false,
                                ]
                                ],

                                [
                                    'question'=>'The acceleration at a given instant of time is called as:',
                                    'subject'=>'Physics',
                                    'option'=>[
                                        'Average acceleration'=>false,
                                        'Instantaneous acceleration'=>true,
                                        'Variable acceleration'=>false,
                                        'Zero acceleration'=>false,
                                    ]
                                    ],

                                    [
                                        'question'=>'Which of these is the force required to move a body uniformly in a circle?',
                                        'subject'=>'Physics',
                                        'option'=>[
                                            'Centrifugal force'=>false,
                                            'Centripetal force'=>true,
                                            'Kinetic force'=>false,
                                            'None of the above'=>false,
                                        ]
                                        ],

        ];

        foreach($questions as $question) {
            $options = $question['option'];
            unset($question['option']);
            $question = Question::create($question);

            foreach($options as $option=>$answer) {
                $optionStatus= $question->options()->create(['option'=>$option]);
                if($answer) {
                    $question->answers()->sync(['option_id'=>$optionStatus->id]);
                }
            }

        }
    }


}
