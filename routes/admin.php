<?php
use Illuminate\Support\Facades\Route;

	Route::get('/agentadmin','Auth\AdminLoginController@getAdminLogin');
	Route::post('agentadmin/login', ['as'=>'admin.login','uses'=>'Auth\AdminLoginController@adminAuth']);
	Route::get('/adminlogout','Auth\AdminLoginController@logout');
	Route::group(['prefix' => 'agentadmin', 'roles' => '1', 'middleware' => ['adminauth','adminroles','lang']], function () {
	    Route::get('/dashboard',  ['as'=>'admin.dashboard','uses' => 'Administrator\Admin\AgentadminController@dashboard'] );
		Route::get('/users',  ['as'=>'admin.users','uses' => 'Administrator\Admin\AgentadminController@users'] );

		/* Change password*/
		Route::get('/password',  ['as'=>'admin.password','uses' => 'Administrator\Admin\AgentadminController@changepassword'] );
		Route::post('/password/changepassword', 'Administrator\ProfileController@changepassword')->name('Change Password');

		/* route for manage Area */
		Route::any('/getAreaList','Administrator\Admin\AreaController@getAreaList');
		Route::post('/deleteArea', 'Administrator\Admin\AreaController@deleteArea');
		Route::get('/areas',  ['as'=>'admin.areas','uses' => 'Administrator\Admin\AreaController@areas'] );
		Route::get('/area/{id?}',  ['as'=>'admin.area','uses' => 'Administrator\Admin\AreaController@area'] );
		Route::post('saveArea', ['as'=>'admin.saveArea','uses'=>'Administrator\Admin\AreaController@save']);

		/* Route For Manage State */
		Route::any('/getStateList','Administrator\Admin\StateController@getStateList');
		Route::get('/states',  ['as'=>'admin.states','uses' => 'Administrator\Admin\StateController@states'] );
		Route::post('/deleteState', 'Administrator\Admin\StateController@deleteState');
		Route::get('/state/{id?}',  ['as'=>'admin.state','uses' => 'Administrator\Admin\StateController@state'] );
		Route::post('saveState', ['as'=>'admin.saveState','uses'=>'Administrator\Admin\StateController@save']);

		/* Route For Manage Cities */
		Route::any('/getCitiesList','Administrator\Admin\CityController@getCitiesList');
		Route::get('/cities',  ['as'=>'admin.cities','uses' => 'Administrator\Admin\CityController@cities'] );
		Route::get('/city/{id?}',  ['as'=>'admin.city','uses' => 'Administrator\Admin\CityController@city'] );
		Route::post('saveCity', ['as'=>'admin.saveCity','uses'=>'Administrator\Admin\CityController@save']);
		Route::post('/deleteCity', 'Administrator\Admin\CityController@deleteCity');

		/* Route For Manage Franchisees */
		Route::any('/getFranchiseeList','Administrator\Admin\FranchiseeController@getFranchiseeList');
		Route::get('/franchisees',  ['as'=>'admin.Franchisees','uses' => 'Administrator\Admin\FranchiseeController@Franchisees'] );
		Route::get('/franchisee/{id?}',  ['as'=>'admin.Franchisee','uses' => 'Administrator\Admin\FranchiseeController@Franchisee'] );
		Route::post('saveFranchisee', ['as'=>'admin.saveFranchisee','uses'=>'Administrator\Admin\FranchiseeController@save']);
		Route::post('/deleteFranchisee', 'Administrator\Admin\FranchiseeController@deleteFranchisee');

		/* Route For Manage Agent */
		Route::any('/agents/changeDocStatus','Administrator\Admin\AgentController@changeDocStatus');
		Route::any('/checkDocument','Administrator\Admin\AgentController@checkDocument');

		Route::any('/getAgentList','Administrator\Admin\AgentController@getAgentList');

		Route::any('/getClosingDateReportajax/{id}','Administrator\Admin\AgentController@getClosingDateReport');

		Route::get('/agents',  ['as'=>'admin.agents','uses' => 'Administrator\Admin\AgentController@agents'] );

		Route::get('/agents/closingdatereport/{id}',  ['as'=>'admin.agents.closingdatereport','uses' => 'Administrator\Admin\AgentController@closingdatereport'] );

		Route::get('/agent/{id?}',  ['as'=>'admin.agent','uses' => 'Administrator\Admin\AgentController@agent'] );
		Route::any('saveAgent', ['as'=>'admin.saveAgent','uses'=>'Administrator\Admin\AgentController@save']);
		Route::post('/deleteAgent', 'Administrator\Admin\AgentController@deleteAgent');
		Route::get('/agents/view/{id?}',  ['as'=>'admin.agents.view','uses' => 'Administrator\Admin\AgentController@agentsview'] );
		Route::get('/agents/view/{id?}/{role?}',  ['as'=>'admin.agents.view','uses' => 'Administrator\Admin\AgentController@agentsview'] );
		Route::get('/agents/activepost/{userid?}/{roleid?}',  'Administrator\Admin\AgentController@agentactivepost');

		/* Route For Manage Agent */
		Route::any('/getSellerbuyerList','Administrator\Admin\SellerbuyerControllor@getSellerbuyerList');
		Route::get('/sellerbuyers',  ['as'=>'admin.sellerbuyers','uses' => 'Administrator\Admin\SellerbuyerControllor@sellerbuyers'] );
		Route::get('/sellerbuyer/{id?}',  ['as'=>'admin.sellerbuyer','uses' => 'Administrator\Admin\SellerbuyerControllor@sellerbuyer'] );
		Route::post('saveSellerbuyer', ['as'=>'admin.saveSellerbuyer','uses'=>'Administrator\Admin\SellerbuyerControllor@save']);
		Route::post('/deleteSellerbuyer', 'Administrator\Admin\SellerbuyerControllor@deleteSellerbuyer');

		Route::get('/sellerbuyer/view/{id?}',  ['as'=>'admin.sellerbuyer.view','uses' => 'Administrator\Admin\SellerbuyerControllor@sellerbuyerview'] );
		Route::get('/sellerbuyer/postlist/{userid?}/{roleid?}',  'Administrator\Admin\SellerbuyerControllor@sellerbuyerpostlist');
		Route::any('/profile/buyer/post/get/{limit}', 'Administrator\Buyer\PostController@getDetailsByAny');

		/*post details*/
		Route::get('/post/details/{userid?}/{roleid?}/{post_id?}',  'Administrator\Admin\AgentadminController@postdetails');
		Route::get('/profile/buyer/post/details/agents/get/{limit}/{post_id}/{userid}/{roleid}', 'Administrator\Buyer\PostController@PostDetailsAgentsGetForBuyer');
		Route::any('/getpostlist','Administrator\Admin\AgentadminController@getPostList');
		Route::get('/posts',  ['as'=>'admin.getpost','uses' => 'Administrator\Admin\AgentadminController@Post'] );
		Route::post('/deletepost', 'Administrator\Admin\AgentadminController@deletePost');

		/*applied post and agents */
		Route::get('/applied/post/list/get/{limit}/{userid}/{roleid}', 'Administrator\ProfileController@AppliedPostListGetForAgents');

		/* Agent proposale*/
		Route::get('/agent/proposal/get/ten/{limit}/{userid}/{roleid}', 'Administrator\Admin\ProposalsController@showten');
		Route::get('/agent/proposal/delete/{id}', 'Administrator\Admin\ProposalsController@delete');

		/* A/B/S files upload and share*/
		Route::get('/uploadshare/get/ten/{limit}/{userid}/{roleid}', 'Administrator\Admin\UploadAndShareController@showten');
		Route::get('/uploadshare/delete/{id}', 'Administrator\Admin\UploadAndShareController@delete');

		/*QuestionAnswers*/
		Route::any('/question/get', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@show');
		Route::any('/question/get/only/user', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@getonlyusersquestion');
		Route::any('/updatequestion', 'Administrator\Agents\QuestionAnswers\QuestionAnswersController@update');

		/* Route For Manage Skills/Specialization */
		Route::any('/getSpecializationList','Administrator\Admin\SpecializationController@getSpecializationList');
		Route::get('/specializations',  ['as'=>'admin.specializations','uses' => 'Administrator\Admin\SpecializationController@specializations'] );
		Route::get('/specialization/{id?}',  ['as'=>'admin.specialization','uses' => 'Administrator\Admin\SpecializationController@specialization'] );
		Route::post('/saveSpecialization', ['as'=>'admin.saveSpecialization','uses'=>'Administrator\Admin\SpecializationController@save']);
		Route::post('/deleteSpecialization', 'Administrator\Admin\SpecializationController@deleteSpecialization');

		/* Route For Manage Certifications */
		Route::any('/getcertificationslist','Administrator\Admin\CertificationsController@getCertificationsList');
		Route::get('/certifications',  ['as'=>'admin.certifications','uses' => 'Administrator\Admin\CertificationsController@Certifications'] );
		Route::get('/certificationsaddedit/{id?}',  ['as'=>'admin.certificationsaddedit','uses' => 'Administrator\Admin\CertificationsController@Certificationsaddedit'] );
		Route::post('/savecertifications', ['as'=>'admin.savecertifications','uses'=>'Administrator\Admin\CertificationsController@save']);
		Route::post('/deletecertifications', 'Administrator\Admin\CertificationsController@deleteCertifications');

		/* Route For Manage Question & Answers */
		Route::get('/getquestionanswers',  ['as'=>'admin.getQuestionAnswers','uses' => 'Administrator\Admin\QuestionAnswersController@index'] );
		Route::any('/getquestionanswerslist','Administrator\Admin\QuestionAnswersController@getQuestionAnswersList');
		Route::post('/deletequestionanswers', 'Administrator\Admin\QuestionAnswersController@deleteQuestionAnswers');
		Route::get('/questionanswers/{id?}',  ['as'=>'admin.QuestionAnswers','uses' => 'Administrator\Admin\QuestionAnswersController@questioneditadd'] );
		Route::post('/savequestionanswers', ['as'=>'admin.saveQuestionAnswers','uses'=>'Administrator\Admin\QuestionAnswersController@create']);
		Route::get('/questionviewwithanswer/{question_id?}', 'Administrator\Admin\QuestionAnswersController@show');

		/* Route For Manage Skills & Specialization */
		Route::get('/getsecurtyquestion',  ['as'=>'admin.getsecurtyquestion','uses' => 'Administrator\Admin\SecurtyQuestionController@index'] );
		Route::any('/getsecurtyquestionList','Administrator\Admin\SecurtyQuestionController@getsecurtyquestionList');

		/*delete*/
		Route::post('/deletesecurtyquestion', 'Administrator\Admin\SecurtyQuestionController@deletesecurtyquestion');

		/*add / edit*/
		Route::get('/securtyquestionaddedit/{id?}',  ['as'=>'admin.securtyquestionaddedit','uses' => 'Administrator\Admin\SecurtyQuestionController@securtyquestionaddedit'] );
		Route::post('/savesecurtyquestion', ['as'=>'admin.savesecurtyquestion','uses'=>'Administrator\Admin\SecurtyQuestionController@save']);

		/* Route for Mange Notification */
		Route::get('/getnotification',  ['as'=>'admin.getnotification','uses' => 'Administrator\Admin\NotificationController@index'] );
		Route::any('/getNotificationList','Administrator\Admin\NotificationController@getNotificationList');
		Route::post('/deleteNoti', 'Administrator\Admin\NotificationController@deleteNoti');

		Route::get('post/validatepost',  ['as'=>'admin.validatepost','uses' => 'Administrator\Admin\AgentadminController@conent'] );

		Route::post('post/validatepost',  ['as'=>'admin.postupdate','uses' => 'Administrator\Admin\AgentadminController@updatewords'] );

		Route::get('employee/addemployee',  ['as'=>'admin.employee.add','uses' => 'Administrator\Admin\EmployeeController@create'] );

		Route::post('addemployee',  ['as'=>'admin.addemployee','uses' => 'Administrator\Admin\EmployeeController@store'] );

		Route::get('employee/employeelist',  ['as'=>'admin.employee.employeelist','uses' => 'Administrator\Admin\EmployeeController@employeelist'] );
		Route::get('employee/changestatus',  ['as'=>'employee.changestatus','uses' => 'Administrator\Admin\EmployeeController@changestatus'] );

		Route::get('agentadmin/showdoc',  ['as'=>'agentadmin.showdoc','uses' => 'Administrator\Buyer\PostController@showdoc'] );
		// Blog
		Route::get('blog/addblog',  ['as'=>'admin.blog.add','uses' => 'Administrator\Admin\EmployeeController@showadd'] );
		Route::post('addblog',  ['as'=>'admin.addblog','uses' => 'Administrator\Admin\EmployeeController@blogstore'] );
		Route::get('blog/bloglist',  ['as'=>'admin.blog.bloglist','uses' => 'Administrator\Admin\EmployeeController@bloglist'] );
		Route::get('/blog/editblog/{id}',  'Administrator\Admin\EmployeeController@editblog');

		Route::get('blog/changestatus',  ['as'=>'blog.changestatus','uses' => 'Administrator\Admin\EmployeeController@blogchangestatus'] );
		Route::post('blog/editblog',  ['as'=>'admin.updateblog','uses' => 'Administrator\Admin\EmployeeController@updateblog'] );

		Route::get('blog/category',  ['as'=>'admin.blog.categorylist','uses' => 'Administrator\Admin\EmployeeController@catlist'] );

		Route::post('blog/category',  ['as'=>'employee.addcat','uses' => 'Administrator\Admin\EmployeeController@catstore'] );

		Route::put('blog/category',  ['as'=>'employee.updatecat','uses' => 'Administrator\Admin\EmployeeController@catupdate'] );

		/* Route For Manage Package */

		Route::get('/package',  ['as'=>'admin.package','uses' => 'Administrator\Admin\PackageController@index'] );
		Route::get('/package/{id?}',  ['as'=>'admin.editpackage','uses' => 'Administrator\Admin\PackageController@editpackage'] );
		Route::post('/package',  ['as'=>'admin.updatepackage','uses' => 'Administrator\Admin\PackageController@updatepackage'] );

		Route::get('/adrequests',  ['as'=>'admin.adrequests','uses' => 'Administrator\Admin\PackageController@adrequests'] );
		Route::get('/adaction/{ad_id}/{action}',  ['as'=>'admin.adaction','uses' => 'Administrator\Admin\PackageController@adaction'] );

		Route::get('/chats',  ['as'=>'admin.chats','uses' => 'Administrator\Admin\ConversationController@chats']);


		Route::post('employee/delete_employee', ['as'=>'employee.delete_employee','uses' => 'Administrator\Admin\EmployeeController@delete_employee']);
		Route::post('employee/deletecat', ['as'=>'employee.deletecat','uses' => 'Administrator\Admin\EmployeeController@deletecat']);

		Route::post('/selldetails',  ['as'=>'admin.selldetails','uses' => 'Administrator\Buyer\PostController@selldetails'] );

		Route::any('/pendinginvoices',  ['as'=>'admin.pendinginvoices','uses' => 'Administrator\Admin\AgentController@pendinginvoices'] );

		/* Route For Conversation */
		Route::get('/conversation',  ['as'=>'admin.conversation','uses' => 'Administrator\Admin\ConversationController@conversation'] );

		Route::get('/conversation/conversationdetails/{id}',  'Administrator\Admin\ConversationController@conversationdetails');

		Route::post('/selectagentbyadmin',  ['as'=>'admin.selectagentbyadmin','uses' => 'Administrator\Admin\AgentadminController@selectagentbyadmin'] );

	});
