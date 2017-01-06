# Snippet Bag
Snippet Bag is a home for your code snippets. Snippets may be private or can be set to public and shared with your friends. Basic email/password authentication as well as Google oauth2 are used. An admin system is also included.

This project was built using:
* Laravel
* Scout for admin full-text search using tnt
* Socialite for google oauth2
* Eloquent Sluggable for url slugs
* Prismjs for syntax highlighting with user-saved themes

## Live Site
[See it in action](http://snippetbag.herokuapp.com/)

## Installation

Clone this repo on to your machine, run composer install process, move
`.env.example` to `.env` and set up your app's environment variables, run
`php artisan migrate`, then run the app `php artisan serve`. Users and snippets can also be seeded into the app using `php artisan db:seed`. This will also create an admin user with admin@admin.com/password login credentials.
