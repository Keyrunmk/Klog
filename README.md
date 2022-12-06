Klog - A simple blog

Features:
Users
-> A user can be registered
-> Only registered when user is verified
-> Registration using jwt
-> Upon registration user's location at the time is stored permanenty and automatically
-> A user has one profile (automatically created upon user registration)
-> A user can have many posts
-> A user can post comments
-> A user can hit (like) posts

Profile
-> A profile can have an image, title, description and url

Posts
-> Upon post creation, the location is stored automatically and permanently
-> A post belongs to a user
-> A post can have many comments
-> A post can have many hits (likes)
-> A post can have many tags
-> A post can have an image

Comments
-> A comment belongs to a user

Tags
-> Tags belong to posts

Images
-> Image can belong to Posts and User(Profile)

WEB
-> Home Page (show posts on the basis of location if user is not registered else display posts of tags user chose during registration) --todo
-> Before registration completes, user is made to agree policies (if agreed status is active, if not can't register) --todo
-> After user registration, user can choose tags of stuffs that user likes --todo
-> After user registration, send email (Events and listeners)
-> Repositories
-> Tried to follow SOLID principles
-> Search (using:["post.names", "author.name", "category" ,"#tags"]) --todo

Extras
-> A post can be reported for violating blog policies (user status may be banned or warned - two warnings is banned) --todo
-> Switchd from laragon to docker/ laravel sail
-> Cache, Jobs and queues --todo
-> Query optimization and database techniques --todo
-> jwt for admin
-> laravel passport/jwt for users --todo
-> socailite --todo
-> laravel octane --todo
-> macros
-> enum

ADMIN
-> Admin login
-> Admin can create madnagers and editors
-> Admin can change blog settings
-> Roles and Permissions
-> Gates and Policies

Managers
-> Managers can create categories --todo
-> Managers can create editors and assign tasks (cannot manage posts) --todo

Moderators
-> Moderator answers user queries --todo

Editors
-> Editors can moderate user post requests, issue them warning or ban them temporarily or permanently  --todo

Admin Logic
-> Super admin registration
-> Super admin can create managers, moderators, editors
-> Super admin has all permissions that managers, moderators and editors have
-> Super admin also has permissions to change blog post names and such settings

-> While super user creates managers, moderators or editors, super user isn't logged out