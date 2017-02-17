<html>
	<head>
		<title>MaiTutor API</title>
		<style>
			
			body {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;;
				font-size: 10pt;
			}
			.sidebar {
				position: fixed;
				top: 0;
				left: 0;
				bottom: 0;
				width: 200px;
				background: #f5f5f5;
				padding: 0 10px;
				overflow-y: auto;
			}
			
			.main {
				padding: 5px 10px;
				margin-left: 220px;
			}
			
			ul {
				margin: 0;
				padding: 0 0 0 10px;
				list-style: none;
			}
			
			.box {
				border: 1px solid #ddd;
				padding: 5px 15px;
				margin-bottom: 20px;
			}
			
			.box h3 {
				color: #185ab6;
				font-size: 16pt;
			}
		</style>
	</head>
	<body>
		<div class="sidebar">
			<h3>Released API</h3>
			
			<p><strong>Endpoint</strong><br />
				&nbsp;&nbsp;&nbsp;http://maitutor.com/api
			</p>
			
			
			<p><strong>User</strong>
			<ul class="side">
				<li><a href="#user-signup">user/signup</a></li>
				<li><a href="#user-auth">user/auth</a></li>
				<li><a href="#user-data">user/data</a></li>
				<li><a href="#user-fbauth">user/fbauth</a></li>
				<li><a href="#user-fbcomplete">user/fbcomplete</a></li>
				<li><a href="#user-pwdreset">user/pwdreset</a></li>
				<li><a href="#user-logout">user/logout</a></li>
			</ul>
			</p>
			
			<p style="color: grey"><strong>MaiTutor</strong>
			<ul class="side" style="color: grey">
				<li><a href="#maitutor-search">maitutor/search</a></li>
				<li><a href="#maitutor-profile">maitutor/profile</a></li>
				<li><a href="#maitutor-request">maitutor/request</a></li>
				<li><a href="#maitutor-get-schedule">maitutor/get_schedule</a></li>
				<li><a href="#maitutor-get-sessions">maitutor/get_sessions</a></li>
				<li><a href="#maitutor-get-requests">maitutor/get_requests</a></li>
				
				<!--
				<li><a href="#maitutor-accept-request">maitutor/accept_request</a></li>
				<li><a href="#maitutor-decline-request">maitutor/decline_request</a></li>
				-->
				<li><a href="#maitutor-checkout-request">maitutor/checkout_request</a></li>
				<li><a href="#maitutor-checkout-cancel">maitutor/checkout_cancel</a></li>
				<li><a href="#maitutor-process-checkout">maitutor/process_checkout</a></li>
				<li><a href="#maitutor-submit-review">maitutor/submit_review</a></li>
				<li><a href="#maitutor-report-card">maitutor/report_card</a></li>
				
				
			</ul>
			</p>
			
			
			<p style="color: grey"><strong>Tutor</strong>
			<ul class="side" style="color: grey">
				<li><a href="#tutor-get-clients">tutor/get_clients</a></li>
				<li><a href="#tutor-get-schedule">tutor/get_schedule</a></li>
				<li><a href="#tutor-get-sessions">tutor/get_sessions</a></li>
				<li><a href="#tutor-get-requests">tutor/get_requests</a></li>
				<li><a href="#tutor-accept-request">tutor/accept_request</a></li>
				<li><a href="#tutor-decline-request">tutor/decline_request</a></li>
				<li><a href="#tutor-start-session">tutor/start_session</a></li>
				<li><a href="#tutor-end-session">tutor/end_session</a></li>
				
			</ul>
			</p>
			
			<p style="color: grey"><strong>Notifications</strong>
			<ul class="side" style="color: grey">
				<li><a href="#notification-all">notification/all</a></li>
				<li><a href="#notification-unread">notification/unread</a></li>
			</ul>
			
			<p style="color: grey"><strong>Chat</strong>
			<ul class="side" style="color: grey">
				<li><a href="#chat-conversations">chat/conversations</a></li>
				<li><a href="#chat-detail">chat/detail</a></li>
			</ul>
			
			<p style="color: grey"><strong>System</strong>
			<ul class="side" style="color: grey">
				<li><a href="#system-info">system/info</a></li>
			</ul>
		</div>
		<div class="main">

<div class="box">		
<h3><a name="user-signup">user/signup</a></h3>
<p>Register a user into MaiTutor database.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	request: "user/signup",
	data: {
		firstname: "John",
		lastname: "Doe",
		email: "john@doe.com",
		password: "johndoe123",
		dob: "1985-01-31",
		mobile: "01234556789"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>

<code><pre>
{
	request: "user/signup",
	datetime: "2016-08-10 10:39:52",
	status: "success",
	authkey: "7c4a8d09ca3762af61e59520943dc26494f8941b"
}
</pre></code>

<p><strong>Error Response</strong></p>

<code><pre>
{
	request: "user/signup",
	datetime: "2016-08-10 10:39:52",
	status: "error",
	error: "Form error",
	reason: "Account already exists."
}
</pre></code>
</div>
			
			
			
			
			
<div class="box">			
<h3><a name="user-auth">user/auth</a></h3>

<p>Authenticate user.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	request: 'user/auth',
	data: {
		email: "john@doe.com",
		password: "password123"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>

<code><pre>
{
	request: "user/auth",
	datetime: "2016-08-10 10:39:52",
	status: "success",
	authkey: "7c4a8d09ca3762af61e59520943dc26494f8941b",
	user: {
		email: "john@doe.com",
		firstname: "John",
		lastname: "Doe",
		...
	}
}
</pre></code>

<p><strong>Error Response</strong></p>

<code><pre>
{
	request: "user/auth",
	datetime: "2016-08-10 10:39:52",
	status: "error",
	error: "Auth error",
	reason: "Incorrect password."
}
</pre></code>

</div>





<div class="box">			
<h3><a name="user-data">user/data</a></h3>

<p>Get user data.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	request: "user/data",
	authkey: "7c4a8d09ca3762af61e59520943dc26494f8941b"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>

<code><pre>
{
	request: "user/data",
	datetime: "2016-08-10 10:39:52",
	status: "success",
	user: {
		email: "john@doe.com",
		firstname: "John",
		lastname: "Doe",
		...
	}
}
</pre></code>

<p>Supplying a wrong authorization key will result with an error.</p>

<p><strong>Error Response</strong></p>
<code><pre>
{
	request: "user/data",
	datetime: "2016-08-10 10:39:52",
	status: "error",
	error: "Unauthorized",
	reason: "Invalid authorization key."
}
</pre></code>

</div>







<div class="box">			
<h3><a name="user-fbauth">user/fbauth</a></h3>

<p>Authenticate user.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	request: "user/fbauth",
	data: {
		name: "Facebook Name",
		email: "Facebook Email",	
		fbid: "10153613645022885"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>

<code><pre>
{
	request: "user/fbauth",
	datetime: "2016-08-10 10:39:52",
	status: "success",
	authkey: "7c4a8d09ca3762af61e59520943dc26494f8941b",
	user: {
		email: "john@doe.com",
		firstname: "John",
		lastname: "Doe",
		...
	}
}
</pre></code>


</div>
		
		
		
		
		
		
		
		
<div class="box">			
<h3><a name="user-fbcomplete">user/fbcomplete</a></h3>

</div>
	
	
	
	
<div class="box">		
<h3><a name="user-pwdreset">user/pwdreset</a></h3>


<p>Request password reset.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	request: 'user/pwdreset',
	data: {
		email: 'john@doe.com'
	}

</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
	request: "user/pwdreset",
	datetime: "2016-08-10 10:39:52",
	status: "success",
	email: "john@doe.com",
}
</pre></code>



<p><strong>Error JSON Response</strong></p>
<code><pre>
{
	request: "user/pwdreset",
	datetime: "2016-08-10 10:39:52",
	status: "error",
	error: "Reset error",
	reason: "Account does not exist."

}
</pre></code>


</div>
			


<div class="box">
<h3><a name="user-logout">user/logout</a></h3>


<p>Logout user session.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	request: 'user/logout',
	authkey: '7c4a8d09ca3762af61e59520943dc26494f8941b'
}

</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
	request: "user/logout",
	datetime: "2016-08-10 10:39:52",
	status: "success",
}
</pre></code>

</div>










<div class="box">
<h3><a name="maitutor-search">maitutor/search</a></h3>


<p>Search tutors.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/search",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"subject": "Mathematics",
		"grade": "Std 1-3",
		"city": "Putrajaya",
		"preferred_time": "Mon - Morning,Mon - Afternoon,Mon - Evening",
		"hours": "1.5 Hours"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
	"status": "success",
	"data": [
		{
		  "id": "33",
		  "type": "tutor",
		  "firstname": "Mr",
		  "lastname": "Tutor",
		  ...
		  "languages": "Bahasa Melayu,English"
		},
		{
		  ...
		},
		...
	],
	"request": "maitutor/search",
	"datetime": "2016-11-18T03:35:31+08:00"
}
</pre></code>

</div>






<div class="box">
<h3><a name="maitutor-profile">maitutor/profile</a></h3>


<p>Get tutor profile by id.</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/profile",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"id": "33",
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
	"status": "success",
	"data": {
		  "id": "33",
		  "type": "tutor",
		  "firstname": "Mr",
		  "lastname": "Tutor",
		  ...
		  "languages": "Bahasa Melayu,English"
		},
	"request": "maitutor/search",
	"datetime": "2016-11-18T03:35:31+08:00"
}
</pre></code>

</div>






<div class="box">
<h3><a name="maitutor-request">maitutor/request</a></h3>


<p>Send tutoring request to tutor.</p>



<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/request",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"to": "tutor@maitutor.com",
		"request": {
			"subject": "Mathematics",
			"grade": "Std 1-3",
			"hours": 1,
			"sessions": 3,
			"student_name": "Ali",
			"student_gender": "Male",
			"student_age": "15",
			"address": "test address",
			"city": "Putrajaya"
		}
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": {
    "status": "Awaiting Confirmation",
    "id": 23
  },
  "request": "maitutor/request",
  "datetime": "2016-11-18T04:20:34+08:00"
}
</pre></code>

</div>







<div class="box">
<h3><a name="maitutor-get-schedule">maitutor/get_schedule</a></h3>


<p>Get schedule.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/get_schedule",
	"authkey": "parent@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "id": "1",
      "job_order_id": "3",
      "job_request_id": "1",
      "user_email": "tutor@plexsol.com",
      "date": "2017-01-02",
      "time": "15:00:00",
      "duration": "2",
      "status": "Hired",
      "assessment": null,
      "assessment_seen": null,
      "assessment_seen_datetime": null,
      "assessment_datetime": null,
      "parent_email": null,
      "session_start": null,
      "session_end": null,
      "request_from": "parent@plexsol.com",
      "request_to": "tutor@plexsol.com",
      "request_data": "{\"subject\":\"Mathematics\",\"rate\":\"5000\",\"grade\":\"Std 1-3\",\"hours\":\"2 hours\",\"sessions\":\"5\",\"student_name\":\"Shafiq\",\"student_age\":\"12\",\"student_gender\":\"Male\",\"address1\":\"41 Lrg Indah\",\"city\":\"Bukit Mertajam\"}",
      "remarks": null,
      "datetime": "2016-12-15 23:56:47",
      "session_status": "Scheduled",
      "session_id": "37"
    }
  ],
  "request": "tutor/get_schedule",
  "datetime": "2016-12-29T10:19:26+08:00"
}
</pre></code>

</div>	







<div class="box">
<h3><a name="maitutor-get-sessions">maitutor/get_sessions</a></h3>


<p>Get sessions.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/get_sessions",
	"authkey": "parent@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
	  {
		  "id": "20",
		  "job_order_id": "19",
		  "job_request_id": "27",
		  "user_email": "tutor@plexsol.com",
		  "date": "2017-01-23",
		  "time": "10:00:00",
		  "duration": "1",
		  "status": "Scheduled",
		  "assessment": "",
		  "assessment_seen": "",
		  "assessment_seen_datetime": "",
		  "assessment_datetime": "",
		  "parent_email": "",
		  "session_start": "",
		  "session_end": ""
	  }
  ],
  "request": "tutor/get_sessions",
  "datetime": "2016-12-29T10:21:45+08:00"
}
</pre></code>

</div>	





<div class="box">
<h3><a name="maitutor-get-requests">maitutor/get_requests</a></h3>


<p>Get tutoring request.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
from    - user email where the request originated from
to      - tutor email of the requet made to
status  - (Optional) filters the results based on status <strong>[Awaiting Confirmation|Pending Payment|Declined|Cancelled|Hired]</strong>
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/get_requests",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"from": "parent@email.com",
		"to": "tutor@email.com"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "id": "19",
      "request_from": "parent@email.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "2 hours",
        "sessions": "5",
        "student_name": "Ahmad",
        "student_age": "10",
        "student_gender": "Male",
        "address1": "TEST",
        "city": "Subang Jaya"
      },
      "remarks": null,
      "datetime": "2016-10-19 07:03:11",
      "status": "Pending Payment"
    },
    {
      "id": "18",
      "request_from": "parent@email.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "1.5 hours",
        "sessions": "5",
        "student_name": "Adam",
        "student_age": "5",
        "student_gender": "Female",
        "address1": "Taman Ribnea",
        "city": "Subang Jaya"
      },
      "remarks": null,
      "datetime": "2016-10-19 06:51:07",
      "status": "Hired"
    }
}
</pre></code>

</div>








<!--
<div class="box">
<h3><a name="maitutor-accept-request">maitutor/accept_request</a></h3>


<p>Get tutoring request.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
from    - user email where the request originated from
to      - tutor email of the requet made to
status  - (Optional) filters the results based on status <strong>[Awaiting Confirmation|Pending Payment|Declined|Cancelled|Hired]</strong>
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/profile",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"from": "parent@email.com",
		"to": "tutor@email.com"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "id": "19",
      "request_from": "parent@email.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "2 hours",
        "sessions": "5",
        "student_name": "Ahmad",
        "student_age": "10",
        "student_gender": "Male",
        "address1": "TEST",
        "city": "Subang Jaya"
      },
      "remarks": null,
      "datetime": "2016-10-19 07:03:11",
      "status": "Pending Payment"
    },
    {
      "id": "18",
      "request_from": "parent@email.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "1.5 hours",
        "sessions": "5",
        "student_name": "Adam",
        "student_age": "5",
        "student_gender": "Female",
        "address1": "Taman Ribnea",
        "city": "Subang Jaya"
      },
      "remarks": null,
      "datetime": "2016-10-19 06:51:07",
      "status": "Hired"
    }
}
</pre></code>

</div>

-->







<!--
<div class="box">
<h3><a name="maitutor-decline-request">maitutor/decline_request</a></h3>


<p>Get tutoring request.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
from    - user email where the request originated from
to      - tutor email of the requet made to
status  - (Optional) filters the results based on status <strong>[Awaiting Confirmation|Pending Payment|Declined|Cancelled|Hired]</strong>
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/profile",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"from": "parent@email.com",
		"to": "tutor@email.com"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "id": "19",
      "request_from": "parent@email.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "2 hours",
        "sessions": "5",
        "student_name": "Ahmad",
        "student_age": "10",
        "student_gender": "Male",
        "address1": "TEST",
        "city": "Subang Jaya"
      },
      "remarks": null,
      "datetime": "2016-10-19 07:03:11",
      "status": "Pending Payment"
    },
    {
      "id": "18",
      "request_from": "parent@email.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "1.5 hours",
        "sessions": "5",
        "student_name": "Adam",
        "student_age": "5",
        "student_gender": "Female",
        "address1": "Taman Ribnea",
        "city": "Subang Jaya"
      },
      "remarks": null,
      "datetime": "2016-10-19 06:51:07",
      "status": "Hired"
    }
}
</pre></code>

</div>
-->





<div class="box">
<h3><a name="maitutor-checkout-request">maitutor/checkout_request</a></h3>


<p>Prepare for checkout and retrieve possible day/time combinations.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
request_id    - request id 
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/checkout_request",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"request_id": "19",
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": {
      "id": "19",
      "request_from": "sha@fiq.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "2 hours",
        "sessions": "5",
        "student_name": "Ahmad",
        "student_age": "10",
        "student_gender": "Male",
        "address1": "TEST",
        "city": "Subang Jaya"
      },
      "currency": "MYR",
      "amount": "200.00",
      "possible_daytimes": ["Mon - 9AM" , "Mon - 10AM", "Mon - 3PM"],
      "remarks": null,
      "datetime": "2016-10-19 07:03:11",
      "status": "Pending Payment"
  }
}
</pre></code>

</div>








<div class="box">
<h3><a name="maitutor-checkout-cancel">maitutor/checkout_cancel</a></h3>


<p>Cancel an request that is Awaiting Payment.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
request_id    - request id 
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/cancel_request",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"request_id": "19",
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": {
      "id": "19",
      "request_from": "sha@fiq.com",
      "request_to": "tutor@email.com",
      "request_data": {
        "subject": "Mathematics",
        "rate": "5000",
        "grade": "Std 1-3",
        "hours": "2 hours",
        "sessions": "5",
        "student_name": "Ahmad",
        "student_age": "10",
        "student_gender": "Male",
        "address1": "TEST",
        "city": "Subang Jaya"
      },
      "currency": "MYR",
      "amount": "200.00",
      "remarks": null,
      "datetime": "2016-10-19 07:03:11",
      "status": "Cancelled"
  }
}
</pre></code>

</div>





<div class="box">
<h3><a name="maitutor-process-checkout">maitutor/process_checkout</a></h3>


<p>Process checkout.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
session_dates    - session dates in YYYY-MM-DD separated by a comma e.g. "2017-01-01,2017-01-07,2017-01-14"
session_times    - session time in HH:MMaa format e.g. "08:30PM"
request_id       - tutor request id
message          - (Optional) message from parent to tutor
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/process_checkout",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"session_dates": "2017-01-01,2017-01-07,2017-01-14",
		"session_time": "08:30PM",
		"request_id": "21",
		"message": "hi tutor!"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "order_id": "19",
      "gateway_url": "https://billplz.com/pay/12a3f9",
    }
}
</pre></code>

</div>	









<div class="box">
<h3><a name="maitutor-submit-review">maitutor/submit_review</a></h3>


<p>Submit review to tutor.</p>

<p><strong>Parameters</strong><br />
	<code><pre>
tutor_email    - tutor email
review         - user review
rating         - rating of integer from 1 to 5
	</pre></code>
</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/submit_review",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d",
	"data": {
		"tutor_email": "parent@email.com",
		"review": "this tutor is a great teacher!",
		"rating": "5"
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": {
   	 "review_count": "9",
   	 "review_rating": "3.6"
  }
}
</pre></code>

</div>	








<div class="box">
<h3><a name="maitutor-report-card">maitutor/report_card</a></h3>


<p>Get list of report cards.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "maitutor/report_cards",
	"authkey": "sha@fiq.com#6d194a375810d3543b20da69f25525ff96db934d"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
	  {
		  "id": "20",
		  "job_order_id": "19",
		  "job_request_id": "27",
		  "user_email": "tutor@plexsol.com",
		  "date": "2017-01-23",
		  "time": "10:00:00",
		  "duration": "1",
		  "status": "Scheduled",
		  "assessment": "Your son has performed better",
		  "assessment_seen": "",
		  "assessment_seen_datetime": "",
		  "assessment_datetime": "",
		  "parent_email": "sha@fiq.com",
		  "session_start": "",
		  "session_end": ""
	  }
  ]
}
</pre></code>

</div>	












<div class="box">
<h3><a name="tutor-get-clients">tutor/get_clients</a></h3>


<p>Get clients.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/get_clients",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "client": "parent@plexsol.com"
    }
  ],
  "request": "tutor/get_clients",
  "datetime": "2016-12-29T10:18:32+08:00"
}
</pre></code>

</div>	




<div class="box">
<h3><a name="tutor-get-schedule">tutor/get_schedue</a></h3>


<p>Get schedule.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/get_schedule",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "id": "1",
      "job_order_id": "3",
      "job_request_id": "1",
      "user_email": "tutor@plexsol.com",
      "date": "2017-01-02",
      "time": "15:00:00",
      "duration": "2",
      "status": "Hired",
      "assessment": null,
      "assessment_seen": null,
      "assessment_seen_datetime": null,
      "assessment_datetime": null,
      "parent_email": null,
      "session_start": null,
      "session_end": null,
      "request_from": "parent@plexsol.com",
      "request_to": "tutor@plexsol.com",
      "request_data": "{\"subject\":\"Mathematics\",\"rate\":\"5000\",\"grade\":\"Std 1-3\",\"hours\":\"2 hours\",\"sessions\":\"5\",\"student_name\":\"Shafiq\",\"student_age\":\"12\",\"student_gender\":\"Male\",\"address1\":\"41 Lrg Indah\",\"city\":\"Bukit Mertajam\"}",
      "remarks": null,
      "datetime": "2016-12-15 23:56:47",
      "session_status": "Scheduled",
      "session_id": "37"
    }
  ],
  "request": "tutor/get_schedule",
  "datetime": "2016-12-29T10:19:26+08:00"
}
</pre></code>

</div>	







<div class="box">
<h3><a name="tutor-get-sessions">tutor/get_sessions</a></h3>


<p>Get sessions.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/get_sessions",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
	  {
		  "id": "20",
		  "job_order_id": "19",
		  "job_request_id": "27",
		  "user_email": "tutor@plexsol.com",
		  "date": "2017-01-23",
		  "time": "10:00:00",
		  "duration": "1",
		  "status": "Scheduled",
		  "assessment": "",
		  "assessment_seen": "",
		  "assessment_seen_datetime": "",
		  "assessment_datetime": "",
		  "parent_email": "",
		  "session_start": "",
		  "session_end": ""
	  }
  ],
  "request": "tutor/get_sessions",
  "datetime": "2016-12-29T10:21:45+08:00"
}
</pre></code>

</div>	








<div class="box">
<h3><a name="tutor-get-requests">tutor/get_requests</a></h3>


<p>Get tutoring requests.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/get_requests",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": [
    {
      "id": "1",
      "request_from": "parent@plexsol.com",
      "request_to": "tutor@plexsol.com",
      "request_data": "{\"subject\":\"Mathematics\",\"rate\":\"5000\",\"grade\":\"Std 1-3\",\"hours\":\"2 hours\",\"sessions\":\"5\",\"student_name\":\"Shafiq\",\"student_age\":\"12\",\"student_gender\":\"Male\",\"address1\":\"41 Lrg Indah\",\"city\":\"Bukit Mertajam\"}",
      "remarks": null,
      "datetime": "2016-12-15 23:56:47",
      "status": "Hired"
    }
  ],
  "request": "tutor/get_requests",
  "datetime": "2016-12-29T10:26:22+08:00"
}
</pre></code>

</div>	









<div class="box">
<h3><a name="tutor-accept-request">tutor/accept_request</a></h3>


<p>Accept tutoring requests.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
request_id    - request id
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/accept_request",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"request_id": 1
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": {
      "id": "1",
      "request_from": "parent@plexsol.com",
      "request_to": "tutor@plexsol.com",
      "request_data": "{\"subject\":\"Mathematics\",\"rate\":\"5000\",\"grade\":\"Std 1-3\",\"hours\":\"2 hours\",\"sessions\":\"5\",\"student_name\":\"Shafiq\",\"student_age\":\"12\",\"student_gender\":\"Male\",\"address1\":\"41 Lrg Indah\",\"city\":\"Bukit Mertajam\"}",
      "remarks": null,
      "datetime": "2016-12-15 23:56:47",
      "status": "Awaiting Payment"
  },
  "request": "tutor/accept_request",
  "datetime": "2016-12-29T10:26:22+08:00"
}
</pre></code>

</div>	









<div class="box">
<h3><a name="tutor-decline-request">tutor/decline_request</a></h3>


<p>Decline tutoring requests.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
request_id    - request id
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/decline_request",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"request_id": 1
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "data": {
      "id": "1",
      "request_from": "parent@plexsol.com",
      "request_to": "tutor@plexsol.com",
      "request_data": "{\"subject\":\"Mathematics\",\"rate\":\"5000\",\"grade\":\"Std 1-3\",\"hours\":\"2 hours\",\"sessions\":\"5\",\"student_name\":\"Shafiq\",\"student_age\":\"12\",\"student_gender\":\"Male\",\"address1\":\"41 Lrg Indah\",\"city\":\"Bukit Mertajam\"}",
      "remarks": null,
      "datetime": "2016-12-15 23:56:47",
      "status": "Declined"
  },
  "request": "tutor/decline_request",
  "datetime": "2016-12-29T10:26:22+08:00"
}
</pre></code>

</div>	








<div class="box">
<h3><a name="tutor-start-session">tutor/start_session</a></h3>


<p>Start tutoring session.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
session_id    - session id
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/start_session",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"sesion_id": 1
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "tutor/start_session"
}
</pre></code>

</div>	














<div class="box">
<h3><a name="tutor-end-session">tutor/end_session</a></h3>


<p>End tutoring session.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
session_id    - session id
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/end_session",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"sesion_id": 1
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "tutor/end_session"
}
</pre></code>

</div>









<div class="box">
<h3><a name="notification-all">notification/all</a></h3>


<p>Get all notifications.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
page    		- page
post_per_page	- post per page
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/end_session",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"page": 1,
		"post_per_page": 50
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "notification/all",
  "total": 2,
  "data": [
	  {
		"user_email": "tutor@plexsol.com",
		"message": "<strong>Ahmad Albab</strong> has requested to hire you",
		"url": "tutor/request_details/1",
		"datetime": "2016-12-15 23:56:47",
		"seen": 1,
		"from_user": "parent@plexsol.com",
	  },
	  {
		"user_email": "tutor@plexsol.com",
		"message": "<strong>Parent One</strong> has requested to hire you",
		"url": "tutor/request_details/2",
		"datetime": "2017-01-05 07:34:47",
		"seen": 1,
		"from_user": "parent@plexsol.com",
	  }
  ]
}
</pre></code>

</div>		






<div class="box">
<h3><a name="notification-unread">notification/unread</a></h3>


<p>Get all unread notifications.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "tutor/end_session",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "notification/unread",
  "total": 1,
  "data": [
	  {
		"user_email": "tutor@plexsol.com",
		"message": "<strong>Ahmad Albab</strong> has requested to hire you",
		"url": "tutor/request_details/1",
		"datetime": "2016-12-15 23:56:47",
		"seen": 0,
		"from_user": "parent@plexsol.com",
	  }
  ]
}
</pre></code>

</div>










<div class="box">
<h3><a name="chat-conversations">chat/conversations</a></h3>


<p>Get all conversations.</p>


<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "chat/conversations",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4"
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "chat/conversations",
  "total": 2,
  "data": [
	  {
		"id": "275",
		"uid": "parent@plexsol.com-tutor@plexsol.com",
		"from": "parent@plexsol.com",
		"to": "tutor@plexssol.com",
		"last_message": "Would like to request some recommendation on books from you for my kid",
		"last_sender": "parent@plexsol.com",
		"last_seen": "2016-11-12 02:23:24"
		"seen": "1",
		"total_unseen": "0"
	  },
	  {
		"id": "172",
		"uid": "parent@plexsol.com-tutor2@plexsol.com",
		"from": "parent@plexsol.com",
		"to": "tutor2@plexssol.com",
		"last_message": "Here are the list of books you should get for your kids",
		"last_sender": "parent2@plexsol.com",
		"last_seen": "2016-11-12 02:23:24"
		"seen": "0",
		"total_unseen": "3"
	  }
  ]
}
</pre></code>

</div>		







<div class="box">
<h3><a name="chat-detail">chat/detail</a></h3>


<p>Get conversation details.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
page   	- page
limit	- number of messages per page
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "chat/conversations",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"uid": "parent@plexsol.com-tutor@plexsol.com",
		"page": 1,
		"limit": 5
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "chat/detail",
  "total": 3,
  "data": [
	  {
	  	"id": "1001",
		"uid": "parent@plexsol.com-tutor@plexsol.com",
		"from": "parent@plexsol.com",
		"to": "tutor@plexsol.com",
		"message": "Would like to request some recommendation on books from you for my kid",
		"datetime": "2016-11-12 02:23:24"
		"seen": "1",

	  },
	  {
		"id": "1001",
		"uid": "parent@plexsol.com-tutor@plexsol.com",
		"from": "tutor@plexsol.com",
		"to": "parent@plexsol.com",
		"message": "Here are the list...",
		"datetime": "2016-11-12 02:25:20"
		"seen": "1",
	  },
	  {
	  	"id": "1001",
		"uid": "parent@plexsol.com-tutor@plexsol.com",
		"from": "parent@plexsol.com",
		"to": "tutor@plexssol.com",
		"message": "Thank you!",
		"datetime": "2016-11-12 02:26:01"
		"seen": "1",

	  }
	  
  ]
}
</pre></code>

</div>		






<div class="box">
<h3><a name="system-info">system/info</a></h3>


<p>Get system related info.</p>


<p><strong>Parameters</strong><br />
	<code><pre>
config   	- name of config, possible values [parent_tnc|tutor_tnc|good_fit_policy]
	</pre></code>
</p>

<p><strong>JSON Request</strong></p>
<code><pre>
{
	"request": "system/info",
	"authkey": "tutor@plexsol.com#1fb97ebed2cd1778fe5c8c4fb216cd1a54f3a2c4",
	"data": {
		"config": "parent_tnc",
	}
}
</pre></code>


<p><strong>Successful JSON Response</strong></p>
<code><pre>
{
  "status": "success",
  "request": "system/info",
  "config": "parent_tnc",
  "data": "........"
}
</pre></code>

</div>		



		
		</div>
	</body>
</html>