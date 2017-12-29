# Project Assignment

Design and implement a **Conference Scheduler** using **PHP (Symfony)** and **HTML / CSS / JavaScript**. The project must meet all the requirements listed below

## Requirements

### **Use PHP** – the major part of your work should be PHP written
- You **must use Symfony Framework**
- You have to additionally use **HTML5, CSS3** to create the content and to stylize your web application
- You may optionally use **JavaScript, jQuery, Bootstrap**
- Use **PHP 7**

### **User source control system**
- **Use GitHub** or other source control system as project collaboration platform and commit your daily work

### **Valid and high-quality PHP, HTML and CSS**
- Follow the best practices for PHP development: http://www.phptherightway.com, https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md, http://symfony.com/doc/current/best_practices/index.html 
- Validate (when possible) your HTML (http://validator.w3.org) and CSS code (http://css-validator.org)
- Follow the best practices for **high-quality PHP, HTML and CSS**: good formatting, good code structure, consistent naming etc.

### **Usability, UX and browser support**
- Your web application should be easy-to-use, with intuitive UI, with good usability (usability != beauty)
- Ensure your web application works correctly in the latest HTML5-compatible browsers: Chrome, Firefox, IE, Opera, Safari (latest versions, desktop and mobile versions)
- You do not need to support old browsers like IE9

## Conference Scheduler

**Required** functionalities:
* User registration / login and user profiles.
* User roles (user, site administrator, conference owner, conference administrator).
* Creating a conference. Becoming a conference owner.
	- `Manage the conference venue`
	- `Manage the conference venue’s halls`
	- `Managing the program – lectures, breaks, etc… They should be time boxed. If it’s led by someone – add the speaker profile.` 
	- `Invite users for speakers. When user is invited as a speaker one receives a notification. By accepting the invitation, automatically the program is edited and the new lecture with its speaker is added.`
	- `Managing conference administrators.`
	- `Discard the conference`
* View open conferences
* View particular conference
* Mark lectures as `must visit` (register for the lecture). If lecture is marked as `must visit`, each other lecture that collides in the time-box should be blurred and not available for `must visit`.
* `Maximum lectures` functionality where users receive suggestion from the system which lectures to visit in order to visit maximum number of lectures possible (that do not have time collision) for that conference. If there are two (or more) combinations of maximum possible lectures, the user should see them both (or more). User should be able to accept the combination, thus marking as `must visit` each of the lectures in that combination.
* View your own schedule (which lectures you are registered for)
* Halls should have users limit
* Do not let users to exceed the halls limit.  
* Site administrators have full access to each conference, each lecture and each user’s profile
* Conference administrators have full access to a particular conference except the venue, halls and discarding the conference.

## Bonus functionalities

*	User groups (e.g. companies, schools, universities, etc…)
*	Users initial cash
*	Pay model. Users have cash and can pay entrance. The conference administrators and owners should have an option to create free-pass (limited count) for certain users and user groups. 
*	Conference revenue-share model. E.g. organizer (owner) pays 50% to the venue owners. The other 50% distributes to the other conference administrators or speakers.
*	Users from user groups should be able to see if they can receive a free-pass for any conference and eventually get that pass.
*	Venue goods. Coffee, tea, sweets, lunch, etc…
*	Free-pass access level. Which venue goods the pass can have access to.

# Build technologies:

## PHP
* **Symfony** framework
* **Twig** view engine
* **Doctrine** ORM
* **MySQL** database




