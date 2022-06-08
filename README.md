# HR Tracker (Formerly referred to as Whiteboard)
A web based human resource tool, that helps keep track of employees whilst providing vital information need for day to day operation.

![image](https://user-images.githubusercontent.com/52069413/172271618-acf6d4f0-ba5c-42b5-866f-8b4d52e7e4ad.png)



# Why does this exist?
In light of the pandemic that has brought most of the world to a grinding halt, organizations and businesses having to switch to a work from home model, but this in itself has brought along with it a problem, not every organization has a functioning human resource tracker, thereby causing a lapse in information on 
who is in and has what duty, with them having to call/email most of the time to verify thereby losing valuable time.

# Does it Work?
While this is in no means by itself a perfect product, the implementation of this project aims to fix the aforementioned problem, by making the 
information that is needed easily available and at a glance, and this would in turn reduce the time lost trying to find out by who has what duty significantly.

# Mobile Friendly?
Unfortunately it is not truly mobile friendly, while it does try this project was never intended for mobile resolutions from its inception and while I would really like to make it so, that is not a main focus at this point in time, but once the project gets
gets to a stage where all the intended changes and fixes are applied I will make sure to so (please bear with me).

# Who can use it?
That depends on your intended usecase, but this project despite being a pet project is mostly intended for businesses that don't require all the fancy functions 
present in premium HR software like logged hours, pay calculation or work history etc. just think of this project as a basic whiteboard that employees can easily
refer to, when they need to find basic information such as who's working, where and who has specific roles.

# Will you add the aforementioned fancy features?
Unfortunately there is no plan in the works to add said features.

# What do you plan to do then?
I am glad you asked that, while this project does do everything i wanted it to do when i initially started it, it is however in a very crude state so going 
forward i plan to rewrite the codebase and optimize (tie up loose ends hehee) the project as a whole with the main intent to make it as dynamic as possible
to make it easily deployable should you want to use it regardless of your business focus so as long as your usecase fits what intended the project for.

# I'll make your project more badass than it is right now!
By all means please do, but bear in mind the current license attached to the project, i don't care if you decide not to pay your respects (shout me out please),
just remember open-source is life.

# I can't wait any longer how can i set it up?
The project was setup and hosted using WampServer v.3.2.3.3 on Windows alternatively the project can be run with any other web development solution stack on any platform.

WampServer can be downloaded from here: https://www.wampserver.com/en/

After downloading wamp (please choose a version according to your specific system architecture i.e.: 32bit (x86) or 64bit (x64)), double click the downloaded file to start the installation process and follow the steps listed below:

1.	Choose Preferred Language and press next.
2.	Accept the License agreement and click next.
3.	On the next screen please carefully read the information and proceed as required, download and install the stated prerequisite software and restart the installation process
a.	If you don’t recognize any of the dependencies at first glance it is advised that you follow the instructions on this page closely so as to make sure that WAMP works as intended.
b.	 If you have all the dependencies or have used a similar application to WAMP like XAMP without any issues, you can proceed by pressing next.

![image](https://user-images.githubusercontent.com/52069413/172273416-9ac05a47-1965-41ea-b988-00ca77c68ea4.png)





- WAMP 32-bit required packages:
   - Microsoft Visual C++ 2008 SP1 Redistributable Package (x86)
   - Microsoft Visual C++ 2010 SP1 Redistributable Package (x86)
   - Microsoft Visual C++ 2012 (select vcredist_x86.exe)
 
- WAMP 64-bit required packages:
   - Microsoft Visual C++ 2008 SP1 Redistributable Package (x64) 
   - Microsoft Visual C++ 2008 Redistributable Package (x64)
   - Microsoft Visual C++ 2010 SP1 Redistributable Package (x64)
   - Microsoft Visual C++ 2012 (select vcredist_x64.exe)

4.	Please choose the base of your C drive for the installation as is recommended in the instruction brief.

![image](https://user-images.githubusercontent.com/52069413/172273656-cb51c3b7-f566-4902-aefe-12faca6f5923.png)
















5.	After installation is complete, please start the application title Wampserver as admin.
6.	Be sure to also add the security exception for Apache in Windows Firewall.

![image](https://user-images.githubusercontent.com/52069413/172273717-9c05a8fc-f5c5-4d4e-8ad9-db2ec1e0f560.png)


Now you can copy the project to the www directory within the WAMP installation folder:

![image](https://user-images.githubusercontent.com/52069413/172273783-d8d8f459-87ee-46d9-a751-5b1149888158.png)














Next you have to set up a database for use with the project, in the database folder within the project folder there exists two sql files one titled hrtracker.sql which would enable you create the db structure without any data for use with the project and the other titled quickstart.sql which would enable create the db structure and also import dummy data to enable you quickly get setup.

![image](https://user-images.githubusercontent.com/52069413/172273812-adc13353-d3dc-438f-a41a-70e4302b2ae7.png)


















To run the whichever sql file you choose please open a browser and go to this address 127.0.0.1 which is the localhost address of your computer and if WAMP was installed properly and all the dependencies exist you should be greeted with the page below:

![image](https://user-images.githubusercontent.com/52069413/172273830-8c87c952-08a6-495b-b501-fccd025ac380.png)


 

Now you can either click on the phpMyAdmin link or use http://127.0.0.1/phpmyadmin/ to access the database management tool, your default user name should be root with no password as shown below unless you have changed it previously at this point which you will need to change the details in the db.php file located in the database folder of the project (see db config)


![image](https://user-images.githubusercontent.com/52069413/172273863-147da541-c7c8-4d97-b219-4a04129aa0fa.png)

















Once you are logged in please use the import option as shown in the image below to select your chosen sql file, use the default options and you should be good to go.

![image](https://user-images.githubusercontent.com/52069413/172273912-980ed168-615a-4b23-bbe6-4462d07d29a3.png)

 
Now you can load the project within your browser using the link: http://127.0.0.1/HRTracker_2/

Regardless of the sql file you chose you will be greeted with a login page as shown below: 

The default HR Manager login email is test@email.com and password is: 12345
Login and have fun.

![image](https://user-images.githubusercontent.com/52069413/172273927-ce9181c0-59b8-4d10-9356-8592954781da.png)












To test the email functionality for when you create a new user or generate a new password you will have to download and install the Test Mail Server Tool: https://toolheap.com/test-mail-server-tool/
This tool will help you to emulate sending emails from your localhost machine as it would of the project was being hosted.
Installing to the default location using the default settings is okay
See images below:

![image](https://user-images.githubusercontent.com/52069413/172273947-038a99f1-b266-4935-a347-957622ab15ab.png)












-	Click next twice and let the installation complete.
-	Now go to your desktop and run “Test Mail Server Tool”
-	Make sure to allow the app through your firewall should the option popup similar to when we were installing WAMP
-	The application should be running in your notification area, double click on it to open the window:


![image](https://user-images.githubusercontent.com/52069413/172273969-9a1d3290-043b-475e-9b50-95c76f0beb67.png)









-	Once you’ve confirmed that the program is running, you can change the path where the program stores the sent emails.
-	Please remember to restart WAMP after the installation of the Test Mail Server Tool
-	For good measure if this is your first time using WAMP please make sure you restart your PC after installing it so that it can work properly with the Test Mail Server Tool.

