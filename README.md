# General Instructions

This assessment is designed to evaluate your skills and experience in Laravel development.
You should have a good understanding of Laravel framework and its components.
You are free to use any resources available to you, including official Laravel documentation, package documentation, and online resources such as StackOverflow.
You are free to use any laravel package.

## Part 1: Application Architecture

You are required to design a database schema for a blog application.
The blog should have the following features:
- Posts should have a title, content, an author, and slug.
- Posts should be able to have multiple tags.
- Posts should be able to have categories.
- Categories should be able to have a parent category.
- Users should be able to add comments to posts.
- Users should be able to create an account and log in to the application.
- Users should be able to edit and delete their own posts and comments.


## Part 2: Coding Challenge

You are required to build a RESTful API for the blog application using Laravel framework.
The API should have the following endpoints:

1. Return a list of all posts with their tags and authors. Users should be able to filter the results by author and/or tags and/or categories.
2. Create a new post.
3. Return the details of a single post by `id` and `slug`  with its tags and author .
4. Update a post.
5. Delete a post.
6. Create a new comment for a post.
7. Return a list of all posts created by a user.
8. Return a list of all comments created by a user.
9. Return a list of all categories

> You should seed `categories` and `tags`.

You should follow the best practices for building RESTful APIs, including using appropriate HTTP status codes, handling errors gracefully, and using authentication and authorization.

You should use Laravel's built-in features, such as Eloquent ORM, migrations, and validation.


You should use Laravel's query builder or Eloquent ORM to implement the filtering feature.

> OPTIONAL: You should provide a clear and concise documentation for the API, including the endpoints, request and response formats, and authentication requirements.

## Part 3: Logic Challenge

Implement the following specs:

- When a new post is created, it should automatically add a tag "new" to the post.
- When a post is updated, it should check if the title or content has changed. If either has changed, it should automatically add a tag "edited" to the post.
- When a post is deleted, it should delete all comments associated with the post.
- When a comment is created a notification(via email) should be sent to the author. 

## Submission Guidelines

- Use the `develop` branch for the development.
- You should submit your code with a pull request to the `main` branch.
- Your code should be well-organized and commented, and follow the PSR coding standards.
- You should include a `README` file that provides instructions for running the application, and any other information you think is relevant.
- You should also include a document that explains your design decisions, the challenges you faced, and how you overcame them.
- You should submit your code and documentation within **3 days**  of receiving this assessment.

Good luck!
