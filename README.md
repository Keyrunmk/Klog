Klog - A simple blog

Features:
Users
-> A user can be registered
-> Registration using jwt
-> A user has one profile (automatically created upon user registration)
-> A user can have many posts
-> A user can post comments

Profil
-> A profile can have an image

Posts
-> A post belongs to a user
-> A post can have many comments
-> A post can have many tags
-> A post can have an image

Comments
-> A comment belongs to a user

Tags
-> Tags belong to posts

Images
-> Image can belong to Posts and User(Profile)

WEB
-> Home Page (show posts on the basis of location if user is not registered else display posts of tags user chose)
-> Before registration completes, user is made to agree of policies
-> After user registration completion, user can choose tags of stuffs that user likes
-> After user registration, send email (Events and listeners)
-> Cache, Jobs and queues
-> Gates and Policies
-> Repositories and design patterns (SOLID)
-> Search

Extras
-> A post can be reported for violating blog policies

ADMIN
-> Admin login
-> Admin can create managers and editors
-> Admin can change blog settings
-> Roles and Permissions
-> Gates and Policies

Managers
-> Managers can create editors and assign tasks (cannot manage posts)

Editors
-> Editors can moderate user post requests, issue them warning or ban them temporarily or permanently
