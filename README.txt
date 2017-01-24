Project Name -- eAttendance

Description
-------------------------------------------------------------------------------
eAttendance is a online Attendance System, used for tracking user's attendance,
user's leaves, user's office intime and outtime and total working hours.

How to Use
-------------------------------------------------------------------------------
1. Download eattendance folder.
2. Import 'eAttendance_new.sql' in database with database name 'eAttendance'.
3. Login with Username and Password.


Commands to run cron jobs
-------------------------------------------------------------------------------
Daily at 06:00 AM
00 06 * * * php /home/sprytechies/www/eattendance/app/cli.php main create

at 11:30 PM
30 23 * * * php /home/sprytechies/www/eattendance/app/cli.php time create


To Start Project
--------------------------------------------------------------------------------
Username - admin@eattendance.com
Password - sprytechies

Change Database Setting
--------------------------------------------------------------------------------
app/config/config.php/
	--'database'
	--'mail'

**Changes required for send Mail 