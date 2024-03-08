# Shrň.to

## Disclaimer

***This code somewhat works, but is not actively maintained. If you find
a bug though, you can let me know and I will try to fix it.***

## NEW: Deploy this site with Docker

All you have to do is to run this command and you are ready to go.
```bash
docker compose up
```

## About project

### Last changes: August 2021

The name of this project could be translated as *Sum it up* and the name
basically speaks for it; it's a project that lets you take some source and
*sum it up* for others, so they can get a basic understanding of a topic, and
if they are interested, they can dive deeper into it.

Features it contains are e.g.:

- Adding, editing and deleting of articles and features like embeds and
[collapsibles](https://www.w3schools.com/howto/howto_js_collapsible.asp)
- User profiles with name, unique username and profile picture that you can
change later
- Logging in/out with SESSIONs and cookies (remembers login)
- Roles (user, admin, owner)
- Listing all articles

## My comments and observations

This project was meant mainly as a "test project" where I could apply my
knowledge of HTML/(S)CSS/JS, PHP and SQL, with the side-effect of getting to
know how web servers like Apache HTTP Server work.

Even if the code is "wrong" in most ways you can imagine, I'm, after all,
still impressed with some features, e.g.

- Storing passwords as hashes with salting and even peppering
- Categories, which work on a "parent-child" basis and are written from scratch
- Own wrapper around SQL library
- Focus on CSS-pure style (no JS animations)
- Using corresponding HTML tags like `nav` for navigation and `footer` for... 
footer 😎
- Using a templating strategy
- Storing database details in `.htaccess`
- Sanitizing text from users

## Technologies used
- HTML/CSS/JS
- Sass (SCSS)
- PHP
- SQL (MySQL)
- Apache HTTP Server
