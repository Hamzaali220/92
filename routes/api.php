<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/dashboard', 'Api\DashboardController@selectedPosts');
    Route::post('/notes', 'Api\NotesController@GetnotesListByDashbord');
    Route::get('/bookmarks', 'Api\BookmarkController@GetBookmarkListByDashbord');
    Route::post('/tests', 'Api\QuestionAnswersController@show');
    Route::post('/buyerPosts', 'Api\DashboardController@BuyerPosts');

    /* notes */
    Route::post('/deleteNotes', 'Api\NotesController@delete');
    Route::post('/updateNote', 'Api\NotesController@update');
    Route::post('/addNotes', 'Api\NotesController@create');

    Route::post('/getPostDetails', 'Api\DashboardController@PostDetailsForBuyer');
    //Route::post('/getPostDetailsAbby','Api\DashboardController@getSelectedDetailsByAny');//abby checking
    Route::post('/newpost', 'Api\DashboardController@store');

    Route::post('/changepassword', 'Api\ProfileController@changepassword');

    /*Profile*/
    Route::get('/profile/buyer', 'Api\ProfileController@buyer');
    Route::get('/profile/agent', 'Api\ProfileController@agent');

    Route::get('/security/buyer', 'Api\ProfileController@buyersettings');
    Route::post('/profile/editFields', 'Api\ProfileController@editFields');
    Route::post('/profile/editagentprofile', 'Api\ProfileController@editagentprofile');
    Route::post('/profile/editagentprofessionalprofile', 'Api\ProfileController@editagentprofessionalprofile');
    Route::get('/profile/resume', 'Api\ProfileController@resume');

    Route::post('/profilePicture', 'Api\ProfileController@editprofilepic');
    Route::post('/securtyquestion', 'Api\ProfileController@securtyquestion');
    Route::post('/getuserdetails', 'Api\ProfileController@getUserDetails');
    Route::get('/getsecurtyquestion', 'Api\ProfileController@getsecurityquestions');
    /*edit agent profile */
    Route::Post('/personalbio', 'Api\ProfileController@resume');
    Route::Post('/editpersonalbio', 'Api\ProfileController@editFieldsbio');
    Route::Post('/getpersonalbio', 'Api\ProfileController@showbio');
    Route::Post('/profilesettings', 'Api\ProfileController@profilesettings');
    Route::post('/editagentprofile', 'Api\ProfileController@editagentprofile');

    Route::post('/agentPosts', 'Api\ProfileController@AppliedPostListGetForAgents');
    Route::post('/documents', 'Api\UploadAndShareController@show');


    /* asked question agent */
    Route::post('askedQuestions', 'Api\SharedController@getSharedQuestionAndAnswer');

    Route::post('/questionanswer/show', 'Api\QuestionAnswersController@show');
    Route::any('/questionanswer/updatequestion', 'Api\QuestionAnswersController@update');
    Route::any('/questiontoanswer', 'Api\QuestionAnswersController@questiontoanswer');

    Route::any('/questiontoanswer/updatesurvey', 'Api\QuestionAnswersController@updatesurvey');
    Route::post('/questiontoanswer/deletesurvey', 'Api\QuestionAnswersController@deletesurvey');
    Route::post('/questiontoanswer/removesurvayquestion', 'Api\QuestionAnswersController@removeservaylistquestion');
    Route::any('/question/get/only/user', 'Api\QuestionAnswersController@getonlyusersquestion');
    Route::any('/question/getaskedquestion', 'Api\QuestionAnswersController@getaskedquestion');
    Route::any('/insertquestion', 'Api\QuestionAnswersController@create');
    Route::any('/askedquestion', 'Api\SharedController@create');
    /*find agent */

    Route::post('/searchAgentsList', 'Api\AgentsSearchController@agentslist');
    Route::Post('/agentsDetails', 'Api\AgentsSearchController@agentsdetails');  // connected = 1 , myjobs = 2
    Route::post('/searchAgentsDetails', 'Api\AgentsSearchController@agentsdetails');
    Route::post('/searchPosts', 'Api\BuyerSearchController@postlist');

    Route::post('/Bookmark', 'Api\BookmarkController@create');
    Route::post('/deleteBookmark', 'Api\BookmarkController@delete');
    Route::post('/getBookmarked', 'Api\BookmarkController@GetBookmarkedList');


    /*applied post buyer selecte agent for post*/
    Route::post('/appliedagents', 'Api\DashboardController@AppliedAgents');

    /*  compare */
    Route::any('/compare', 'Api\CompareController@index');
    Route::post('/removeCompare', 'Api\CompareController@delete');
    Route::post('/compare/insert', 'Api\CompareController@create');


    Route::post('/compared', 'Api\CompareController@ComparedDataGetByPost');
    Route::get('/compare/delete/{compare_id}/{user_id}', 'Administrator\Compare\CompareController@delete');

    /*Rating */
    Route::post('/sendratingforagentbybuyerseller', 'Api\RatingController@reviewsend');

    /*Shared*/
    Route::post('/getSharedProposals', 'Api\SharedController@getSharedProposals');

    Route::post('/proposals/store', 'Api\ProposalsController@store');
    Route::post('/proposals/delete', 'Api\ProposalsController@delete');
    Route::post('/uploadandshare/delete/', 'Api\UploadAndShareController@delete');

    /* Files */
    Route::any('/getSharedFiles', 'Api\UploadAndShareController@getfileswithshared');

    // Pending invoices
    Route::post('/getPendingInvoices', 'Api\AgentsSearchController@getPendingInvoices');

    Route::post('/switchuser', 'Api\BuyerSearchController@switchuser');

    // Chat messages
    /*Messaging/ Chat*/
    // Route::get('/messages/{post_id}', 'Api\MessagingChatController@index');
    Route::get('/messages', 'Api\MessagingChatController@index');
    Route::get('/messages/{post_id}/{receiver_id}/{receiver_role_id}', 'Api\MessagingChatController@index');
    Route::get('/NewConversation/{post_id}/{receiver_id}/{receiver_role_id}', 'Api\MessagingChatController@createconversation');

    Route::post('/messageslist/get/conversation', 'Api\MessagingChatController@ConversationList');
    Route::post('/messageslist/get/conversation/messages', 'Api\MessagingChatController@ConversationMessagesList');
    Route::get('/messageslist/get/sended', 'Api\MessagingChatController@SendedMessage');
    Route::post('/messageslist/get/unread', 'Api\MessagingChatController@UnreadMessage');
    Route::post('/insert/new/messages', 'Api\MessagingChatController@InsertNewMessage');
    Route::post('/read/update/messages', 'Api\MessagingChatController@readupdate');

    /* Get the notifications list*/
    Route::get('/notifications/{limit}', 'Api\MessagingChatController@getnotifications');
    Route::get('/notifications/read/{id}', 'Api\MessagingChatController@update');
    // Route::get('/contactus', 'Front\HomeController@contact');

    
Route::post('contactSend','Api\ProfileController@contactSend');
Route::post('/paymentagents', 'Api\ProfileController@paymentagents');
Route::post('/saveCard', 'Api\ProfileController@saveCard');

    /* add closing date api */
    Route::post('/addclosingdate', 'Api\AgentsSearchController@addclosingdate');
});
Route::any('/franchise', 'Api\ProfileController@franchise');
Route::post('/login', ['uses' => 'Api\LoginController@login']);
Route::post('/signup1', ['uses' => 'Api\SignUpController@signup']);
Route::post('/signup2', ['uses' => 'Api\SignUpController@signup2']);
Route::post('/signup3', ['uses' => 'Api\SignUpController@signup3']);
Route::post('/state', ['uses' => 'Api\StateController@states']);
Route::post('/sellOptions', ['uses' => 'Api\StateController@whenDoYouWantToSell']);
Route::post('/forgotPassword', 'Api\PasswordController@resetcodesend');

/* Bookmark */

Route::post('/bookmark/data/insert', 'Api\BookmarkController@create');
Route::post('/uploadFileDemo', 'Api\UploadAndShareController@uploadFileDemo');
