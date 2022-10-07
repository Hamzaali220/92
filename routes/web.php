<?php

use Illuminate\Support\Facades\Route;
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

/*lang*/
use App\User;
use Carbon\Carbon;

Route::any('/lang/{lg}', 'Front\LangaugeController@index');

/*public pages*/
Route::get('/terms', 'Front\HomeController@terms');
Route::get('/usersendreviewupdate', function () {
	mail('kamlesh74420@gmail.com', 'usersendreviewupdate', 'usersendreviewupdate');
	// $user = new User;
	// print_r($user->usersendreviewupdate());
});

Route::get('/agentStatus', 'Administrator\DashboardController@agentStatus');
Route::get('/privacy', 'Front\HomeController@privacy');
Route::get('/new-terms', 'Front\HomeController@newTerms');
Route::get('/best-shoots', 'Front\HomeController@bestShoots');
Route::get('/incredible-content', 'Front\HomeController@incredibleContent');
Route::get('/aboutus', 'Front\HomeController@aboutus');

/*Front view of Blog*/
Route::get('/blogs', 'Front\HomeController@blogs');
Route::get('/blogs/{id}/{title}', 'Front\HomeController@singleblogs');
Route::get('/blogs/category/{id}/{title}', 'Front\HomeController@categoryblogs');
Route::post('/blog/comment', 'Front\HomeController@savecomment');
/*=== Front view of Blog Eng ===*/

Route::get('/advertise', 'Front\HomeController@showadvertise');

Route::get('/agent', 'Front\HomeController@agent');
Route::get('/sellers', 'Front\HomeController@sellers');
Route::get('/buyers', 'Front\HomeController@buyers');
Route::get('/contactus', 'Front\HomeController@contact');
Route::get('/downloadContract', 'Administrator\ProfileController@contract');
Route::post('contactSend', ['as' => 'contactSend', 'uses' => 'Front\HomeController@contactSend']);
Route::group(['middleware' => ['lang', 'guest']], function () {

	/*Home*/
	Route::get('/', 'Front\HomeController@index');
	Route::get('/signup/{stype}/', 'Front\HomeController@index');

	/*Authentication Routes...*/
	Route::get('/login', ['as' => 'login', 'uses' => 'Front\HomeController@login']);
	Route::post('/login', 'Auth\LoginController@login');
	Route::post('/login_api', 'Auth\LoginController@login_api');
	
	/* Mobile */
	Route::post('/mobile/login_api', 'Auth\LoginController@login_api');
	Route::post('/mobile/signup1', 'Front\HomeController@signup');
	Route::post('/mobile/signup2', 'Front\HomeController@signup2');
	Route::post('/mobile/signup3', 'Front\HomeController@signup3');
	Route::any('/get_state', 'Administrator\ProfileController@state');

	/*Registration Routes...*/
	Route::post('/signup1', 'Front\HomeController@signup')->name('signup');
	Route::post('/signup2', 'Front\HomeController@signup2')->name('signup');
	Route::post('/signup3', 'Front\HomeController@signup3')->name('signup');
	Route::get('/sendsignupmail/', 'Front\HomeController@NewUserMailSend')->name('sendsignupmail');

	/*Password Reset Routes...*/
	Route::get('/password/reset', 'Front\HomeController@reset')->name('reset');
	Route::post('/password/resetcodesend', 'Auth\ForgotPasswordController@resetcodesend')->name('resetcodesend');
	Route::get('/password/resetcodesendbyadmin/{email}', 'Auth\ForgotPasswordController@resetcodesendbyadmin');
	Route::get('/password/code/{token}', 'Auth\ForgotPasswordController@resetpasswordform')->name('resetpasswordform');
	Route::post('/password/resetpassword', 'Auth\ForgotPasswordController@resetpassword')->name('resetpassword');
	Route::any('/get_city/{state_id}', 'Administrator\ProfileController@city');
});

Route::get('/inputclosingdate', 'Administrator\Search\AgentsSearchController@inputclosingdate');

Route::post('/inputclosingdate', 'Administrator\Search\AgentsSearchController@inputclosingdatestore');

Route::get('/closingdatecronjob', 'Administrator\Search\AgentsSearchController@closingdatecronjob');

Route::group(['middleware' => ['auth', 'lang', 'sTime', 'check-user-activation']], function () {

	/*Search agents*/

	Route::any('/agents', 'Administrator\Search\AgentsSearchController@index');
	Route::any('/search/agents/list/{limit}', 'Administrator\Search\AgentsSearchController@agentslist');
	Route::any('/search/agents/details/{id}', 'Administrator\Search\AgentsSearchController@agentsdetails');

	Route::any('/search/agents/details/{id}/{post_id}', 'Administrator\Search\AgentsSearchController@agentsdetails');

	Route::any('/search/agents/details/{id}/{post_id}/{notitype}', 'Administrator\Search\AgentsSearchController@agentsdetails');

	/*Search post*/
	Route::any('/post', 'Administrator\Search\BuyerSearchController@index');
	Route::any('/postForAgents', 'Administrator\Search\BuyerSearchController@postForAgents');
	Route::any('/switchuser', 'Administrator\Search\BuyerSearchController@switchuser');
	Route::any('/search/post/list/{limit}', 'Administrator\Search\BuyerSearchController@postlist');
	Route::any('/search/post/details/{id}', 'Administrator\Search\BuyerSearchController@postdetails');
	Route::post('/selldetails',  'Administrator\Buyer\PostController@selldetails');

	Route::any('/search/post/details/{id}/{notitype}', 'Administrator\Search\BuyerSearchController@postdetails');
	Route::any('/search/buyer/details/{id}/{roleid}', 'Administrator\Search\BuyerSearchController@buyerdetails');

	/* Logout*/
	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

	/* Dashboard*/
	Route::get('/dashboard', 'Administrator\DashboardController@index')->name('dashboard');
	/*last activity*/

	/* Agent profile*/
	Route::get('/profile/agent', 'Administrator\ProfileController@agent');
	Route::get('/profile/agent/personal', 'Administrator\ProfileController@resume');
	Route::post('/profile/agent/personal', 'Administrator\ProfileController@resume');
	Route::get('/profile/agent/professional', 'Administrator\ProfileController@resume');
	Route::get('/profile/agent/questions', 'Administrator\ProfileController@agentsquestions');
	Route::get('/profile/agent/tests', 'Administrator\ProfileController@agentsquestions');
	Route::get('/profile/agent/settings', 'Administrator\ProfileController@agentsettings');
	Route::get('/profile/agent/security', 'Administrator\ProfileController@agentsettings');
	Route::get('/profile/agent/password', 'Administrator\ProfileController@agentsettings');
	Route::post('/profile/agent/editfields', 'Administrator\ProfileController@editfields');
	Route::post('/profile/agent/editprofilepic', 'Administrator\ProfileController@editprofilepic');
	Route::post('/profile/agent/editAgentPersonalProfile', 'Administrator\ProfileController@editagentprofile');
	Route::post('/profile/agent/sellDetails', 'Administrator\ProfileController@updateSellDetials')->name('update_sell');
	// Route::post('/profile/agent/', 'Administrator\ProfileController@editagentprofessionalprofile');
	Route::post('/profile/agent/editagentprofile', 'Administrator\ProfileController@editagentprofessionalprofile');
	Route::post('/profile/agent/editagentprofessionalprofile', 'Administrator\ProfileController@editagentprofessionalprofile');
	Route::get('/profile/{name}/proposal', 'Administrator\ProfileController@proposal');
	Route::get('/profile/{name}/documents', 'Administrator\ProfileController@documents');

	/* Agent proposale*/
	Route::post('/agent/proposal/insert', 'Administrator\Agents\ProposalsController@store');
	Route::get('/agent/proposal/get/{limit}/{userid}/{roleid}', 'Administrator\Agents\ProposalsController@show');
	Route::get('/agent/proposal/get/ten/{limit}/{userid}/{roleid}', 'Administrator\Agents\ProposalsController@showten');
	Route::get('/agent/proposal/delete/{id}', 'Administrator\Agents\ProposalsController@delete');
	Route::any('/get/proposal/with/shared/{limit}', 'Administrator\Agents\ProposalsController@getproposalwithshared');

	/* Buyer & seller profile*/
	Route::get('/profile/buyer', 'Administrator\ProfileController@buyer');
	Route::get('/profile/buyer/questions', 'Administrator\ProfileController@buyerquestions');
	Route::get('/profile/buyer/tests', 'Administrator\ProfileController@buyerquestions');
	Route::get('/profile/agent/getQuestions/{id}', 'Administrator\ProfileController@getQuestions');
	Route::get('/profile/buyer/settings', 'Administrator\ProfileController@buyersettings');
	Route::get('/profile/buyer/personal', 'Administrator\ProfileController@buyersettings');
	Route::get('/profile/buyer/security', 'Administrator\ProfileController@buyersettings');
	Route::get('/profile/buyer/password', 'Administrator\ProfileController@buyersettings');
	Route::post('/profile/buyer/editfields', 'Administrator\ProfileController@editfields');
	Route::post('/profile/buyer/editbuyerprofile', 'Administrator\ProfileController@editbuyerprofile');

	/*buyer post*/
	Route::get('/profile/buyer/posts', 'Administrator\Buyer\PostController@index');
	Route::get('/profile/buyer/compareposts', 'Administrator\Buyer\PostController@ComparePost');
	Route::any('/profile/buyer/post/get/{limit}', 'Administrator\Buyer\PostController@getDetailsByAny');
	Route::any('/profile/buyer/post/get/selected/{limit}', 'Administrator\Buyer\PostController@getSelectedDetailsByAny');
	Route::get('/profile/buyer/post/details/{post_id}', 'Administrator\Buyer\PostController@PostDetailsForBuyer');
	Route::post('/addClosingDate', 'Administrator\Buyer\PostController@addClosingDate');
	Route::get('/profile/buyer/post/details/{post_id}/{compare}', 'Administrator\Buyer\PostController@PostDetailsForBuyer');
	Route::get('/profile/buyer/post/details/agents/get/few/{post_id}/{userid}/{roleid}', 'Administrator\Buyer\PostController@PostDetailsAgentsGetForBuyerlimitfive');
	Route::get('/profile/buyer/post/details/agents/get/{limit}/{post_id}/{userid}/{roleid}', 'Administrator\Buyer\PostController@PostDetailsAgentsGetForBuyer');
	Route::post('/profile/buyer/updateposttitle', 'Administrator\ProfileController@updateposttitle');
	Route::post('/profile/buyer/post/get', 'Administrator\Buyer\PostController@getpostsingalByAny');
	Route::post('/profile/buyer/newpost', 'Administrator\Buyer\PostController@store');


	/*seller post*/
	Route::get('/profile/seller/posts', 'Administrator\Buyer\PostController@index');
	Route::get('/profile/seller/compareposts', 'Administrator\Buyer\PostController@ComparePost');
	Route::get('/profile/seller/post/details/{post_id}', 'Administrator\Buyer\PostController@PostDetailsForBuyer');
	Route::get('/profile/seller/post/details/{post_id}/{compare}', 'Administrator\Buyer\PostController@PostDetailsForBuyer');
	Route::get('/profile/seller/post/details/agents/get/few/{post_id}/{userid}/{roleid}', 'Administrator\Buyer\PostController@PostDetailsAgentsGetForBuyerlimitfive');
	Route::get('/profile/seller/post/details/agents/get/{limit}/{post_id}/{userid}/{roleid}', 'Administrator\Buyer\PostController@PostDetailsAgentsGetForBuyer');

	Route::post('/validatepaymentamount', 'Administrator\Buyer\PostController@validatepaymentamount');

	/*Security Question*/
	Route::post('/securtyquestion/change', 'Administrator\ProfileController@securtyquestion');

	/* Change password*/
	Route::post('/password/changepassword', 'Administrator\ProfileController@changepassword');

	/*state city area certifications  Specialization franchise */
	Route::any('/state/get/', 'Administrator\ProfileController@state');
	Route::any('/city/get', 'Administrator\ProfileController@city');
	Route::any('/city/get/{state_id}', 'Administrator\ProfileController@city');
	Route::any('/area/get/', 'Administrator\ProfileController@area');
	Route::any('/certifications/get/', 'Administrator\ProfileController@certifications');
	Route::any('/specialization/get/', 'Administrator\ProfileController@specialization');
	Route::any('/franchise/get/', 'Administrator\ProfileController@franchise');
	Route::any('/franchise/get/{id}', 'Administrator\ProfileController@franchise');

	/* A/B/S files upload and share*/
	Route::post('/uploadshare/insert', 'Administrator\UploadAndShareController@store');
	Route::get('/uploadshare/get/{limit}/{userid}/{roleid}', 'Administrator\UploadAndShareController@show');
	Route::get('/uploadshare/get/ten/{limit}/{userid}/{roleid}', 'Administrator\UploadAndShareController@showten');
	Route::get('/uploadshare/delete/{id}', 'Administrator\UploadAndShareController@delete');
	Route::any('/get/uploaded/files/with/shared/{limit}', 'Administrator\UploadAndShareController@getfileswithshared');

	/*QuestionAnswers*/
	Route::any('/question/get', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@show');
	Route::any('/questiontoanswer', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@questiontoanswer');
	Route::any('/allsubmitquestiontoanswer', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@allsubmitquestiontoanswer');
	Route::any('/question/get/only/user', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@getonlyusersquestion');
	Route::any('/updatequestion', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@update');
	Route::any('/insertquestion', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@create');

	/* importance b/s */
	Route::any('/importance', 'Administrator\Buyer\ImportanceController@update');
	Route::any('/importance/list/', 'Administrator\Buyer\ImportanceController@index');
	Route::get('/importance/get/{limit}/{id}/{roleid}', 'Administrator\Buyer\ImportanceController@getLimitedDataByAny');
	Route::get('/importance/delete/{id}', 'Administrator\Buyer\ImportanceController@delete');
	Route::post('/importance/delete', 'Administrator\Buyer\ImportanceController@removeimportancelistquestion');

	/*survey*/
	Route::any('/survey/buyers/list/', 'Administrator\SurveyController@buyersindex');
	Route::any('/survey/agent/list/', 'Administrator\SurveyController@agentsindex');
	Route::any('/survey', 'Administrator\SurveyController@update');
	Route::get('/survey/get/{limit}/{id}/{roleid}', 'Administrator\SurveyController@getLimitedDataByAny');
	Route::get('/survey/delete/{id}', 'Administrator\SurveyController@delete');
	Route::post('/survey/delete', 'Administrator\SurveyController@removeservaylistquestion');
	Route::any('/survey/loop/question/get', 'Administrator\SurveyController@SurvayLoopQuestion');

	/*Search agents*/
	// Route::get('/agents', 'Administrator\Search\AgentsSearchController@index');
	// Route::any('/search/agents/list/{limit}', 'Administrator\Search\AgentsSearchController@agentslist');
	// Route::any('/search/agents/details/{id}', 'Administrator\Search\AgentsSearchController@agentsdetails');
	// Route::any('/search/agents/details/{id}/{post_id}', 'Administrator\Search\AgentsSearchController@agentsdetails');
	// Route::any('/search/agents/details/{id}/{post_id}/{notitype}', 'Administrator\Search\AgentsSearchController@agentsdetails');

	/*Search post*/
	// Route::get('/post', 'Administrator\Search\BuyerSearchController@index');
	// Route::any('/search/post/list/{limit}', 'Administrator\Search\BuyerSearchController@postlist');
	// Route::any('/search/post/details/{id}', 'Administrator\Search\BuyerSearchController@postdetails');
	// Route::any('/search/post/details/{id}/{notitype}', 'Administrator\Search\BuyerSearchController@postdetails');

	/*Shared Data*/
	Route::post('/shared/data/insert', 'Administrator\SharedController@create');
	Route::post('/shared/data/delete', 'Administrator\SharedController@delete');
	Route::post('/shared/question/answer/get', 'Administrator\SharedController@getSharedQuestionAndAnswer');
	Route::post('/shared/upload/files/get', 'Administrator\SharedController@getSharedUploadAndFiles');
	Route::post('/shared/proposals/get', 'Administrator\SharedController@getSharedProposals');
	Route::any('/shared/proposals/with/connected/users/by/{proposal_id}/{userid}/{user_role}', 'Administrator\SharedController@GetSharedPropsalUsersAndConnectedUers');
	Route::any('/shared/documents/with/connected/users/by/{docs_id}/{userid}/{user_role}', 'Administrator\SharedController@GetSharedDocumentUsersAndConnectedUers');
	Route::any('/shared/question/with/connected/users/by/{question_id}/{share_user_type}/{userid}/{user_role}', 'Administrator\SharedController@GetSharedQuestionUsersAndConnectedUers');

	/*skilles*/
	Route::any('/skills/get', 'Administrator\ProfileController@skills');

	/*Messaging/ Chat*/
	Route::get('/messages/', 'Administrator\Messages\MessagingChatController@index');
	// Route::get('/messages/{post_id}', 'Administrator\Messages\MessagingChatController@index');
	Route::get('/messages/{post_id}/{receiver_id}/{receiver_role_id}', 'Administrator\Messages\MessagingChatController@index');
	Route::get('/NewConversation/{post_id}/{receiver_id}/{receiver_role_id}', 'Administrator\Messages\MessagingChatController@createconversation');
	Route::any('/messageslist/get/conversation/{limit}', 'Administrator\Messages\MessagingChatController@ConversationList');
	Route::any('/messageslist/get/conversation/messages/{limit}', 'Administrator\Messages\MessagingChatController@ConversationMessagesList');
	Route::any('/messageslist/get/sended/{limit}', 'Administrator\Messages\MessagingChatController@SendedMessage');
	Route::any('/messageslist/get/unread', 'Administrator\Messages\MessagingChatController@UnreadMessage');
	Route::any('/insert/new/messages', 'Administrator\Messages\MessagingChatController@InsertNewMessage');
	Route::any('/read/update/messages', 'Administrator\Messages\MessagingChatController@readupdate');

	/*public users Connection*/
	Route::post('/users/public/Connection', 'Administrator\ProfileController@publicConnection');
	Route::get('/users/{id}/{roleid}', 'Administrator\ProfileController@publicUserGet');

	/*bookmark*/
	Route::get('/{name}/bookmark/', 'Administrator\BookmarkController@index');
	Route::post('/bookmark/data/insert', 'Administrator\BookmarkController@create');
	Route::get('/bookmark/data/delete/{id}', 'Administrator\BookmarkController@delete');
	Route::get('/bookmarked/get/{id}/{role}/{bookmark_type}/{bookmark_item_id}/{bookmark_item_parent_id}', 'Administrator\BookmarkController@GetBookmarkedList');
	Route::get('/bookmarked/list/get/{limit}', 'Administrator\BookmarkController@GetBookmarkListByDashbord');
	Route::get('/bookmarked/delete/by/{id}', 'Administrator\BookmarkController@delete');

	/*Rating*/
	Route::post('/rating/data/insert', 'Administrator\RatingController@create');
	Route::get('/rating/data/delete/{id}', 'Administrator\RatingController@delete');
	Route::get('/rating/get/{id}/{role}/{rating_type}/{rating_item_id}/{rating_item_parent_id}/{receiver_id}/{receiver_role}', 'Administrator\RatingController@GetRatingedList');
	Route::post('/sendratingforagentbybuyerseller', 'Administrator\RatingController@reviewsend');

	/*Notes*/
	Route::get('/{name}/notes/', 'Administrator\NotesController@index');
	Route::post('/notes/data/insert', 'Administrator\NotesController@create');
	Route::post('/notes/data/update/{id}', 'Administrator\NotesController@update');
	Route::get('/notes/data/delete/{id}', 'Administrator\NotesController@delete');
	Route::get('/notes/get/{id}/{role}/{notes_type}/{notes_item_id}/{notes_item_parent_id}/{receiver_id}/{receiver_role}', 'Administrator\NotesController@GetNotesedList');
	Route::get('/notes/list/get/{limit}', 'Administrator\NotesController@GetnotesListByDashbord');
	Route::get('/notes/delete/by/{id}', 'Administrator\NotesController@delete');

	/*applied post and agents */
	Route::get('/{name}/applied/post', 'Administrator\ProfileController@AppliedPostForAgents');
Route::get('/applied/post/list/get/{limit}/{userid}/{roleid}', 'Administrator\ProfileController@AppliedPostListGetForAgents');
	Route::get('/applied/post/list/get/{limit}/{userid}/{roleid}/{selected}/{user_role_id?}', 'Administrator\ProfileController@AppliedPostListGetForAgents');

	/* connected jobs/post for agents*/
	Route::get('/agent/connected/post', 'Administrator\ProfileController@ConnectedJobsForAgents');

	/*notification*/
	Route::get('/notification/get/{limit}', 'Administrator\NotificationController@index');
	Route::get('/message/notification/get/{limit}', 'Administrator\NotificationController@MessageNotification');
	Route::get('/notification/update/read/{id}', 'Administrator\NotificationController@update');
	//Route::get('/notification/update/read/{id}', 'Administrator\NotificationController@update');
	Route::post('/notification/update/read/by/receiver_id', 'Administrator\NotificationController@UpdateByReceiver_id');

	/*compare*/
	Route::any('/compare', 'Administrator\Compare\CompareController@index');
	Route::get('/compare/list/{limit}/{userid}/{role}/{post_id}', 'Administrator\Compare\CompareController@show');
	Route::get('/compared/data/get/{post_id}/{sender_id}/{sender_role}', 'Administrator\Compare\CompareController@ComparedDataGetByPost');
	Route::post('/compare/insert', 'Administrator\Compare\CompareController@create');
	Route::get('/compare/delete/{compare_id}/{user_id}', 'Administrator\Compare\CompareController@delete');

	/*applied post buyer selecte agent for post*/
	Route::get('/appliedagents/{post_id}/{agentid}', 'Administrator\Buyer\PostController@AppliedAgents');

	/*payment */
	Route::post('/paymentagents', 'Administrator\PaymentController@paymentagents');
	Route::get('/getPaymentByAny/{limit}/{userid}', 'Administrator\PaymentController@getPaymentByAny');

	Route::post('/search/agents/details', ['as' => 'comment.addcomment', 'uses' => 'Administrator\Search\AgentsSearchController@addcomment']);

	Route::get('/buyer/blog', 'Administrator\BlogController@index');
	Route::post('/buyer/blog', ['as' => 'blog.addblog', 'uses' => 'Administrator\BlogController@blogstore']);
	Route::get('/buyer/blog/{id}', 'Administrator\BlogController@delblog');
	Route::get('/buyer/advertisement', 'Administrator\BlogController@advertisement');
	Route::get('/buyer/get/blog/{id}', 'Administrator\BlogController@getSingleBlog');
	Route::post('/buyer/blog/update', ['as' => 'blog.update', 'uses' => 'Administrator\BlogController@singleBlogUpdate']);


	# advertise payment
	Route::get('/paymentpage/{package_id}', 'Administrator\PaymentController@paymentpage');
	Route::post('/postPayment', 'Administrator\PaymentController@postPayment');
	Route::get('/paymentStatus', 'Administrator\PaymentController@paymentStatus');
	Route::get('/manageads', 'Administrator\Agents\AdController@manage');
	Route::any('/configureads/{ad_id?}', 'Administrator\Agents\AdController@configureads');
	Route::get('/adclicks/{ad_id}', 'Administrator\Agents\AdController@adclicks');


	# commision payment
	Route::get('/pendinginvoices', 'Administrator\PaymentController@pendinginvoices');
	Route::post('/pay_pendinginvoices', 'Administrator\PaymentController@pay_pendinginvoices')->name('pay_pendinginvoices');
	Route::get('/pending/pay/{id}', 'Administrator\PaymentController@payitnow')->name('payitnow');
	Route::post('/postAgentPayment', 'Administrator\PaymentController@postAgentPayment');
	Route::post('/downloadinvoice', 'Administrator\PaymentController@downloadinvoice');

	# 11-07-2020
	Route::get('/advertiseinvoice/{ad_id}', 'Administrator\Agents\AdController@advertiseinvoice');

	/* Agent selected posts */
	Route::get('/agent/selected/post', 'Administrator\Agents\PostController@agentSelectedPosts');
	Route::get('/agent/selected/post/get/{limit}/{userid}/{roleid}/{user_role_id?}', 'Administrator\Agents\PostController@agentSelectedPostsAjx');
	Route::get("/agent/myall/selected/post", "Administrator\Agents\PostController@agentSelectedAllPosts");
	/* Test */
	Route::get('/reviewofpost/{post_id}', 'Administrator\RatingController@reviewofpost');
});

//admin routes
require __DIR__ . '/admin.php';
