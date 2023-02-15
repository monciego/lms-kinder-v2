<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ShapeController;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\MathProblemController;
use App\Http\Controllers\ParentInformationController;
use App\Http\Controllers\Auth\RegisteredUserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//auth route for all user 
Route::group(['middleware' => ['auth']], function() { 
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
});

// for admin
Route::group(['middleware' => ['auth' , 'role:admin']], function() { 
    Route::get('subjects/{id}', 'App\Http\Controllers\DashboardController@showSubject')->name('show-subjects');
    Route::get('edit-subjects/{id}', 'App\Http\Controllers\DashboardController@editSubject')->name('edit-subjects');
    Route::post('update-subjects/{id}', 'App\Http\Controllers\DashboardController@updateSubject')->name('update-subjects');
    Route::delete('delete-subject/{id}', 'App\Http\Controllers\DashboardController@deleteSubject')->name('delete-subject');
});

// for admin and teacher
Route::group(['middleware' => ['auth' , 'role:admin|teacher']], function() { 
    Route::resource('accounts', AccountController::class);
});

// for teachers
Route::group(['middleware' => ['auth', 'role:teacher|student']], function() { 
    Route::get('/activities/quizzes/show-math-problem', 'App\Http\Controllers\QuizController@showMathProblem')->name('show-math-problem');
    Route::get('/activities/quizzes/show-color', 'App\Http\Controllers\QuizController@showColor')->name('show-color');
    Route::get('/activities/quizzes/show-quiz-responses/answers/{id}/{quiz_id}', 'App\Http\Controllers\QuizController@showQuizResponseAnswers')->name('show-quiz-response-answers');
    Route::get('/activities/quizzes/show-quiz-responses/{id}', 'App\Http\Controllers\QuizController@showQuizResponses')->name('show-quiz-responses');
    Route::get('/activities/quizzes/show-color-quizzes', 'App\Http\Controllers\QuizController@showColorQuizzes')->name('show-color-quizzes');
    Route::get('/activities/quizzes/show-math-problem-quizzes', 'App\Http\Controllers\QuizController@showMathProblemQuizzes')->name('show-math-problem-quizzes');
    Route::get('/activities/quizzes/show-quizzes/{id}', 'App\Http\Controllers\QuizController@showQuizzes')->name('show-quizzes');
    Route::post('/activities/quizzes/store-result', 'App\Http\Controllers\QuizController@storeResult')->name('store-result');
    Route::get('/activities/shapes/show-shapes', 'App\Http\Controllers\ShapeController@showShape')->name('show-shape');
    Route::post('activities/shapes/store-responses', 'App\Http\Controllers\ShapeController@storeResponses')->name('store-shape-responses');
    Route::get('activities/shapes/show-shape-responses/{id}/{user_id}', 'App\Http\Controllers\ShapeController@showShapeResponses')->name('show-shape-responses');
    Route::get('activities/shapes/return-shape-score/{id}', 'App\Http\Controllers\ShapeController@returnShapeScore')->name('return-shape-score');
    Route::put('activities/shapes/update-shape-score/{id}', 'App\Http\Controllers\ShapeController@updateShapeScore')->name('update-shape-score');
    Route::get('activities/shapes/shape-responses/{id}', 'App\Http\Controllers\ShapeController@shapeResponses')->name('shape-responses');
    Route::get('activities/puzzle/store-puzzle-response-table/{id}', 'App\Http\Controllers\PuzzleController@showPuzzleResponseTable')->name('store-puzzle-response-table');
    Route::get('activities/puzzle/show-puzzle-response-teacher/{id}/{user_id}', 'App\Http\Controllers\PuzzleController@showPuzzleResponseTeacher')->name('store-puzzle-response-teacher');
    Route::get('activities/puzzle/edit-score/{id}', 'App\Http\Controllers\PuzzleController@editScore')->name('edit-score');
    Route::post('activities/puzzle/update-score/{id}', 'App\Http\Controllers\PuzzleController@updateScore')->name('update-score');
    Route::post('activities/puzzle/store-puzzle-responses', 'App\Http\Controllers\PuzzleController@storePuzzleResponse')->name('store-puzzle-responses');
    Route::resource('activities/reading', ReadingController::class);
    Route::resource('activities/quizzes/questions/responses', ResponseController::class);
    Route::resource('activities/quizzes/questions', QuestionController::class);
    Route::resource('activities/quizzes', QuizController::class);
    Route::resource('activities/quizzes/math-problem', MathProblemController::class);
    Route::resource('activities/puzzle', PuzzleController::class);
    Route::resource('activities/shapes', ShapeController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('grade', GradeController::class);
    
    // new routes for redefense
    Route::get('student-progress/{id}', 'App\Http\Controllers\AccountController@studentProgress')->name('student-progress');
    Route::get('show-examinations/{id}', 'App\Http\Controllers\QuizController@showExaminations')->name('show-examinations');
    Route::get('show-exercises/{id}', 'App\Http\Controllers\QuizController@showExercises')->name('show-exercises');
    Route::get('subject/content/{id}', 'App\Http\Controllers\DashboardController@showSubjectContent')->name('show-subject-content');
    Route::get('act/{id}', 'App\Http\Controllers\DashboardController@showAct')->name('show-act');
    Route::get('activities/create/{id}', 'App\Http\Controllers\ActivitiesController@create')->name('activities.create');
    Route::resource('activites', ActivitiesController::class)->only('index', 'show', 'store', 'edit', 'update', 'destroy');
});

// for student
Route::group(['middleware' => ['auth', 'role:student']], function() { 
    Route::get('/dashboard/myprofile', 'App\Http\Controllers\DashboardController@myprofile')->name('dashboard.myprofile');
    Route::resource('parent-information', ParentInformationController::class);
});





require __DIR__.'/auth.php';
