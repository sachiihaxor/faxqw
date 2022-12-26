<?php
# CSRF Protection
Route::when('*', 'csrf', ['POST', 'PUT', 'PATCH', 'DELETE']);

#RSS Feed
Route::get('/sitemap.xml', ['uses' => 'HomeController@rss', 'as' => 'rss']);

Route::get('/researchwap.html', 'HomeController@home');
Route::get('/terms-of-use.html', ['uses' => 'HomeController@terms', 'as' => 'terms-of-use']);
Route::get('/frequently-asked-questions.html', ['uses' => 'HomeController@faq', 'as' => 'faq']);
Route::get('/client-testimonies.html', ['uses' => 'HomeController@testimonies', 'as' => 'testimonies']);
Route::get('/page/gtbank-737.html', 'HomeController@gtbank737');
Route::get('/payment-options/{projectNumber}.html', ['uses' => 'OrdersController@paymentOptions', 'as' => 'paymentOptions']);
Route::post('/success', ['uses' => 'OrdersController@success', 'as' => 'orders.paymentSuccess']);
Route::post('/failed', ['uses' => 'OrdersController@failed', 'as' => 'orders.paymentFailed']);
Route::get('/n', 'OrdersController@notification');
Route::get('/payments', 'HomeController@payments');
Route::get('/payments.html', ['uses' => 'HomeController@payments', 'as' => 'payments']);

// blog
Route::get('/blog', ['uses' => 'BlogController@index', 'as' => 'blog.index']);
// posts
Route::get('/post/{slug}', ['uses' => 'PostsController@show', 'as' => 'post.show']);
// search projects on researchwap route
Route::get('/input-search', ['uses' => 'ProjectsController@getSearchDefault', 'as' => 'getSearch']);

Route::get('/search', array('uses' => 'ProjectsController@searchAllProjects', 'as' => 'postSearch'));


Route::group(array('before' => 'guest'), function() {

	Route::post('/rwap-admin-login', array('uses' => 'HomeController@postLogin', 'as' => 'postLogin'));
	
	// admin login
	Route::get('/rwap-login', array('uses' => 'HomeController@getLogin', 'as' => 'getLogin'));

	Route::post('/password-reset','UsersController@reset');

}); //end protected routes for unauthenticated routes


Route::get('/logoutAdmin', array('uses' => 'HomeController@getLogout', 'as' => 'getLogout'));

Route::get('/', array('uses' => 'HomeController@home', 'as' => 'home'));

Route::get('/about.html', array('uses' => 'HomeController@about', 'as' => 'getAbout'));

Route::get('/contact-us.html', array('uses' => 'HomeController@contact', 'as' => 'getContact'));

Route::get('/request-project', array('uses' => 'HomeController@customProject', 'as' => 'getCustomProject'));

Route::get('/final-year-project-topics.html', array('uses' => 'ProjectsController@browseProjectCategories', 'as' => 'getBrowseProjectCategories'));

Route::get('/project-topics.html', array('uses' => 'ProjectsController@browseProjects', 'as' => 'getBrowseProjects'));

Route::get('/place-project-order.html', array('uses' => 'ProjectOrdersController@placeOrder', 'as' => 'getProjectOrder'));

Route::post('/place-project-order', array('uses' => 'ProjectOrdersController@postProjectOrder', 'as' => 'postProjectOrder'));

Route::get('/order-project/{projectNumber}.html', array('uses' => 'OrdersController@create', 'as' => 'getNewOrder'));

Route::post('/order-project/{projectNumber}', array('uses' => 'OrdersController@store', 'as' => 'postNewOrder'));

// hire a writer
Route::get('/hire-a-writer.html', ['uses' => 'ProjectOrdersController@create', 'as' => 'project-orders.create']);
Route::get('/hire-a-writer', 'ProjectOrdersController@create');
Route::get('/place-custom-project-order', 'ProjectOrdersController@create');

Route::post('/place-project-order', ['uses' => 'ProjectOrdersController@store', 'as' => 'project-orders.store']);

Route::get('/place-project-order-payments', ['uses' => 'ProjectOrdersController@projectOrderPayments', 'as' => 'getProjectOrderPayments']);



// start protected routes
Route::group(array('before' => 'auth', 'prefix' => 'dashboardAdmin'), function() {

	//ADMIN USER ROUTES
	Route::group(['before' => 'admin.admin'], function() {
		
		Route::get('/users', 
		[
			'uses' => 'UsersController@index', 
			'as' => 'admin.userShow'
		]);
		Route::get('/users/create', 
			[
				'uses' => 'UsersController@create', 
				'as' => 'admin.userCreate'
			]);
		Route::post('/users/create', 
			[
				'uses' => 'UsersController@store', 
				'as' => 'admin.userStore'
			]);
		Route::get('/users/edit/{id}', 
			[
				'uses' => 'UsersController@edit', 
				'as' => 'admin.userEdit'
			]);
		Route::post('/users/edit/{id}', 
			[
				'uses' => 'UsersController@update', 
				'as' => 'admin.userUpdate'
			]);
		});
	
	// Route::get('/settings','')

	// department post routes
	Route::post('/add-department', 
		[
			'uses' => 'DepartmentsController@store',
			'as' => 'admin.postAddDepartment'
		]);
	Route::post('/edit-department/{id}', 
		[
			'uses' => 'DepartmentsController@update', 
			'as' => 'admin.postEditDepartment'
		]);
	Route::get('/browse-department', 
		[
			'uses' => 'DepartmentsController@getBrowseDepartments', 
			'as' => 'admin.getDepartments'
		]);
	Route::post('/browse-department-ajax', 
		[
			'uses' => 'DepartmentsController@getBrowseDepartmentsAjax', 
		 	'as' => 'admin.getDepartmentsAjax'
		]);
	Route::get('/browse-department-item', 
		[
			'uses' => 'DepartmentsController@getDepartmentItemAdmin', 
			'as' => 'admin.getDepartmentItemAdmin'
		]);
	Route::get('/add-department', 
		[
			'uses' => 'DepartmentsController@getAddDepartment', 
			'as' => 'admin.getAddDepartment'
		]);

	// ALL PROJECT ROUTES
	Route::post('/add-project', 
		array('uses' => 'ProjectsController@store', 'as' => 'admin.postAddProject'));

	Route::post('/edit-project/{projectNumber}', 
		array('uses' => 'ProjectsController@update', 'as' => 'admin.postEditProject'));

	Route::get('/add-project', 
		array('uses' => 'ProjectsController@getCreate', 'as' => 'getAddProject'));

	Route::get('/edit-project/{projectNumber}', 
		array('uses' => 'ProjectsController@getEdit', 'as' => 'getEditProject'));

	Route::get('', 
		array('uses' => 'HomeController@getDashboard', 'as' => 'getDashboard'));

	Route::get('/browse-projects', 
		array('uses' => 'ProjectsController@getBrowseProjects', 'as' => 'admin.getProjects'));

	Route::get('/browse-projects/{projectNumber}', 
		array('uses' => 'ProjectsController@getProjectItemAdmin', 'as' => 'admin.getProjectItemAdmin'));

	Route::get('/add-project', 
		array('uses' => 'ProjectsController@getCreate', 'as' => 'admin.getAddProject'));

	Route::get('/orders', 
		array('uses' => 'OrdersController@getAllOrders', 'as' => 'admin.getAllOrders'));

	Route::get('/project-orders', 
		array('uses' => 'ProjectOrdersController@getAllProjectOrders', 'as' => 'admin.getAllProjectOrders'));

	Route::get('/view-order/{orderId}', 
		array('uses' => 'OrdersController@getViewOrder', 'as' => 'admin.getViewOrder'));

	Route::get('/view-project-order/{pOrderId}', 
		array('uses' => 'ProjectOrdersController@getViewProjectOrder', 'as' => 'admin.getViewProjectOrder'));

	// routes for only admin and staff
	Route::group(array('before' => 'admin.staff'), function() {

		Route::get('/project-orders', ['uses' => 'ProjectOrdersController@index', 'as' => 'admin.project-orders.index']);

		Route::get('/all-contact-mssg', ['uses' => 'ContactController@getAllContactMssg', 'as' => 'admin.getAllContactMssg']);

		Route::get('/delete-order', ['uses' => 'OrdersController@destroy', 'as' => 'admin.deleteOrder']);

		Route::get('/view-project-order/{pOrderId}', ['uses' => 'ProjectOrdersController@show', 'as' => 'admin.project-orders.show']);
		

	});

	// routes for author writers, staff and admin
	Route::group(['before' => 'author.writer.admin.staff'], function() {
		// blog posts routes
		Route::resource('post', 'PostsController', ['except' => ['show','edit']]);

		// blog posts
		Route::post('/upload-featured-image', ['uses' => 'PostsController@uploadFeaturedImage', 'as' => 'admin.postFeaturedImage']);

		Route::post('/browse-post-ajax', ['uses' => 'PostsController@getBrowsePostsAjax', 'as' => 'admin.getPostsAjax']);

		Route::get('/browse-post-item', ['uses' => 'PostsController@edit', 'as' => 'admin.getPostItemAdmin']);
	});

});

Route::get('/{slug}', 'ProjectsController@getProjectsForDept');
Route::get('/{slug}/', array('uses' => 'ProjectsController@getProjectsForDept', 'as' => 'getProjectsForDept'));

Route::get('/{slug}/{projectNumber}', 'ProjectsController@getProjectItem');
Route::get('/{slug}/{projectNumber}/', array('uses' => 'ProjectsController@getProjectItem', 'as' => 'getProjectItem'));
