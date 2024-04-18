1	user_authorise	auth/mnet/auth.php/user_authorise	auth	mnet	1	Return user data for the provided token, compare with user_agent string.	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:5:"token";s:4:"type";s:6:"string";s:11:"description";s:37:"The unique ID provided by remotehost.";}i:1;a:3:{s:4:"name";s:9:"useragent";s:4:"type";s:6:"string";s:11:"description";s:18:"User Agent string.";}}s:6:"return";a:2:{s:4:"type";s:5:"array";s:11:"description";s:44:"$userdata Array of user info for remote host";}}	auth.php	auth_plugin_mnet	0
2	keepalive_server	auth/mnet/auth.php/keepalive_server	auth	mnet	1	Receives an array of usernames from a remote machine and prods their\
sessions to keep them alive	a:2:{s:10:"parameters";a:1:{i:0;a:3:{s:4:"name";s:5:"array";s:4:"type";s:5:"array";s:11:"description";s:21:"An array of usernames";}}s:6:"return";a:2:{s:4:"type";s:6:"string";s:11:"description";s:28:""All ok" or an error message";}}	auth.php	auth_plugin_mnet	0
3	kill_children	auth/mnet/auth.php/kill_children	auth	mnet	1	The IdP uses this function to kill child sessions on other hosts	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:8:"username";s:4:"type";s:6:"string";s:11:"description";s:28:"Username for session to kill";}i:1;a:3:{s:4:"name";s:9:"useragent";s:4:"type";s:6:"string";s:11:"description";s:35:"SHA1 hash of user agent to look for";}}s:6:"return";a:2:{s:4:"type";s:6:"string";s:11:"description";s:39:"A plaintext report of what has happened";}}	auth.php	auth_plugin_mnet	0
4	refresh_log	auth/mnet/auth.php/refresh_log	auth	mnet	1	Receives an array of log entries from an SP and adds them to the mnet_log\
table	a:2:{s:10:"parameters";a:1:{i:0;a:3:{s:4:"name";s:5:"array";s:4:"type";s:5:"array";s:11:"description";s:21:"An array of usernames";}}s:6:"return";a:2:{s:4:"type";s:6:"string";s:11:"description";s:28:""All ok" or an error message";}}	auth.php	auth_plugin_mnet	0
5	fetch_user_image	auth/mnet/auth.php/fetch_user_image	auth	mnet	1	Returns the user's profile image info\
If the user exists and has a profile picture, the returned array will contain keys:\
f1          - the content of the default 100x100px image\
f1_mimetype - the mimetype of the f1 file\
f2          - the content of the 35x35px variant of the image\
f2_mimetype - the mimetype of the f2 file\
The mimetype information was added in Moodle 2.0. In Moodle 1.x, images are always jpegs.	a:2:{s:10:"parameters";a:1:{i:0;a:3:{s:4:"name";s:8:"username";s:4:"type";s:3:"int";s:11:"description";s:18:"The id of the user";}}s:6:"return";a:2:{s:4:"type";s:11:"false|array";s:11:"description";s:84:"false if user not found, empty array if no picture exists, array with data otherwise";}}	auth.php	auth_plugin_mnet	0
6	fetch_theme_info	auth/mnet/auth.php/fetch_theme_info	auth	mnet	1	Returns the theme information and logo url as strings.	a:2:{s:10:"parameters";a:0:{}s:6:"return";a:2:{s:4:"type";s:6:"string";s:11:"description";s:14:"The theme info";}}	auth.php	auth_plugin_mnet	0
7	update_enrolments	auth/mnet/auth.php/update_enrolments	auth	mnet	1	Invoke this function _on_ the IDP to update it with enrolment info local to\
the SP right after calling user_authorise()\
Normally called by the SP after calling user_authorise()	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:8:"username";s:4:"type";s:6:"string";s:11:"description";s:12:"The username";}i:1;a:3:{s:4:"name";s:7:"courses";s:4:"type";s:5:"array";s:11:"description";s:75:"Assoc array of courses following the structure of mnetservice_enrol_courses";}}s:6:"return";a:2:{s:4:"type";s:4:"bool";s:11:"description";s:0:"";}}	auth.php	auth_plugin_mnet	0
8	keepalive_client	auth/mnet/auth.php/keepalive_client	auth	mnet	1	Poll the IdP server to let it know that a user it has authenticated is still\
online	a:2:{s:10:"parameters";a:0:{}s:6:"return";a:2:{s:4:"type";s:4:"void";s:11:"description";s:0:"";}}	auth.php	auth_plugin_mnet	0
9	kill_child	auth/mnet/auth.php/kill_child	auth	mnet	1	When the IdP requests that child sessions are terminated,\
this function will be called on each of the child hosts. The machine that\
calls the function (over xmlrpc) provides us with the mnethostid we need.	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:8:"username";s:4:"type";s:6:"string";s:11:"description";s:28:"Username for session to kill";}i:1;a:3:{s:4:"name";s:9:"useragent";s:4:"type";s:6:"string";s:11:"description";s:35:"SHA1 hash of user agent to look for";}}s:6:"return";a:2:{s:4:"type";s:4:"bool";s:11:"description";s:15:"True on success";}}	auth.php	auth_plugin_mnet	0
10	available_courses	enrol/mnet/enrol.php/available_courses	enrol	mnet	1	Returns list of courses that we offer to the caller for remote enrolment of their users\
Since Moodle 2.0, courses are made available for MNet peers by creating an instance\
of enrol_mnet plugin for the course. Hidden courses are not returned. If there are two\
instances - one specific for the host and one for 'All hosts', the setting of the specific\
one is used. The id of the peer is kept in customint1, no other custom fields are used.	a:2:{s:10:"parameters";a:0:{}s:6:"return";a:2:{s:4:"type";s:5:"array";s:11:"description";s:0:"";}}	enrol.php	enrol_mnet_mnetservice_enrol	0
11	user_enrolments	enrol/mnet/enrol.php/user_enrolments	enrol	mnet	1	This method has never been implemented in Moodle MNet API	a:2:{s:10:"parameters";a:0:{}s:6:"return";a:2:{s:4:"type";s:5:"array";s:11:"description";s:11:"empty array";}}	enrol.php	enrol_mnet_mnetservice_enrol	0
12	enrol_user	enrol/mnet/enrol.php/enrol_user	enrol	mnet	1	Enrol remote user to our course\
If we do not have local record for the remote user in our database,\
it gets created here.	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:8:"userdata";s:4:"type";s:5:"array";s:11:"description";s:43:"user details {@see mnet_fields_to_import()}";}i:1;a:3:{s:4:"name";s:8:"courseid";s:4:"type";s:3:"int";s:11:"description";s:19:"our local course id";}}s:6:"return";a:2:{s:4:"type";s:4:"bool";s:11:"description";s:69:"true if the enrolment has been successful, throws exception otherwise";}}	enrol.php	enrol_mnet_mnetservice_enrol	0
13	unenrol_user	enrol/mnet/enrol.php/unenrol_user	enrol	mnet	1	Unenrol remote user from our course\
Only users enrolled via enrol_mnet plugin can be unenrolled remotely. If the\
remote user is enrolled into the local course via some other enrol plugin\
(enrol_manual for example), the remote host can't touch such enrolment. Please\
do not report this behaviour as bug, it is a feature ;-)	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:8:"username";s:4:"type";s:6:"string";s:11:"description";s:18:"of the remote user";}i:1;a:3:{s:4:"name";s:8:"courseid";s:4:"type";s:3:"int";s:11:"description";s:19:"of our local course";}}s:6:"return";a:2:{s:4:"type";s:4:"bool";s:11:"description";s:71:"true if the unenrolment has been successful, throws exception otherwise";}}	enrol.php	enrol_mnet_mnetservice_enrol	0
14	course_enrolments	enrol/mnet/enrol.php/course_enrolments	enrol	mnet	1	Returns a list of users from the client server who are enrolled in our course\
Suitable instance of enrol_mnet must be created in the course. This method will not\
return any information about the enrolments in courses that are not available for\
remote enrolment, even if their users are enrolled into them via other plugin\
(note the difference from {@link self::user_enrolments()}).\
This method will return enrolment information for users from hosts regardless\
the enrolment plugin. It does not matter if the user was enrolled remotely by\
their admin or locally. Once the course is available for remote enrolments, we\
will tell them everything about their users.\
In Moodle 1.x the returned array used to be indexed by username. The side effect\
of MDL-19219 fix is that we do not need to use such index and therefore we can\
return all enrolment records. MNet clients 1.x will only use the last record for\
the student, if she is enrolled via multiple plugins.	a:2:{s:10:"parameters";a:2:{i:0;a:3:{s:4:"name";s:8:"courseid";s:4:"type";s:3:"int";s:11:"description";s:16:"ID of our course";}i:1;a:3:{s:4:"name";s:5:"roles";s:4:"type";s:12:"string|array";s:11:"description";s:58:"comma separated list of role shortnames (or array of them)";}}s:6:"return";a:2:{s:4:"type";s:5:"array";s:11:"description";s:0:"";}}	enrol.php	enrol_mnet_mnetservice_enrol	0
15	fetch_file	portfolio/mahara/lib.php/fetch_file	portfolio	mahara	1	xmlrpc (mnet) function to get the file.\
reads in the file and returns it base_64 encoded\
so that it can be enrypted by mnet.	a:2:{s:10:"parameters";a:1:{i:0;a:3:{s:4:"name";s:5:"token";s:4:"type";s:6:"string";s:11:"description";s:56:"the token recieved previously during send_content_intent";}}s:6:"return";a:2:{s:4:"type";s:4:"void";s:11:"description";s:0:"";}}	lib.php	portfolio_plugin_mahara	1
