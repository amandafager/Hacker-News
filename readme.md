# Hacker News

School project in PHP. The assignment was to create clone of the social news website [Hacker News](https://news.ycombinator.com/news).

<details><summary>Required features</summary>

- As a user I should be able to create an account.

- As a user I should be able to login.

- As a user I should be able to logout.

- As a user I should be able to edit my account email, password and biography.

- As a user I should be able to upload a profile avatar image.

- As a user I should be able to create new posts with title, link and description.

- As a user I should be able to edit my posts.

- As a user I should be able to delete my posts.

- As a user I'm able to view most upvoted posts.

- As a user I'm able to view new posts.

- As a user I should be able to upvote posts.

- As a user I should be able to remove upvote from posts.

- As a user I'm able to comment on a post.

- As a user I'm able to edit my comments.

- As a user I'm able to delete my comments.

</details>

#### Extra feature in my project

- As a user I'm able to reply to comments.

### Hacker News Plus - By Jon McGarvie

- As a user I'm able to delete my account, along with every comment, reply, upvote and post that I have made.
- As a user I'm able to upvote and remove my upvote on comments.
- As a user I'm able to view other users upvoted posts and comments.
- https://github.com/trilisen/Hacker-News-Plus

# Technologies

- HTML
- CSS
- JavaScript
- SQL
- PHP

# Installation

1. #### Clone the repository

```
git clone https://github.com/amandafager/Hacker-News.git`
```

```
cd path/to/project/folder/Hacker-News
```

2. #### Start a local server in the command line

```
php -S localhost:8000
```

3. #### Open [http://localhost:8000/index.php ](http://localhost:8000/index.php) in your browser

# Testers

- Moa
- Carolina

# Code Review

### By Jonathan Larsson

- You could check the header-file and the different views for a bit better SEO and general semantics.
- There is an empty class declared in comments.css at line 91.
- I'm not sure that the amount of new lines within blocks of code are needed, in the files where you write both php and html.
  Between blocks it's fine but within blocks maybe they're not needed? It could be just a preference of mine, but make sure it's consistent
  throughout your project.
- You could perhaps consider a more starkly contrasted colour-scheme from an accessibility-standpoint.
- The second point of the installation guide in your readme doesn't work, remember that the index-file is a php-file rather than a html-file. :)

These criticisms are just nitpicky and I'm honestly having trouble finding many points of improvement, overall I think you've done a great job.
The site runs well and seems very well thought out. Good work!

# License

This project is licensed under the MIT License - see the LICENSE file for details
