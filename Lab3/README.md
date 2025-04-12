# Laravel Blog Application

A Laravel-based blog application with features including post management, image uploads, slugs, job queues, and task scheduling.

## Features Implemented

### 1. Post Management with Validation

- Create, read, update, and delete posts
- Form request validation for all inputs
- Title requirements: minimum 3 characters, unique
- Content requirements: minimum 10 characters
- Validation ensures unique titles with proper exception handling for updates

### 2. Automatic Slug Generation

- Slugs automatically generated from post titles
- Uses [cviebrock/eloquent-sluggable](https://github.com/cviebrock/eloquent-sluggable) package
- Slugs displayed in the index page
- URLs are SEO-friendly

### 3. Image Upload System

- Upload images for posts (JPG, PNG only)
- Images stored in the public storage directory
- Automatic image management:
  - Old images are removed when updated
  - Images are deleted when posts are deleted
- Uses Laravel Storage facades and mutators/accessors

### 4. Queue System

- Database queue driver configured
- `PruneOldPostsJob` for removing posts older than 2 years
- Automatically handles image deletion when pruning posts
- Job logs information about deleted posts

### 5. Task Scheduling

- Scheduled task to run `PruneOldPostsJob` daily at midnight
- Uses Laravel's built-in scheduler
- Can be customized to run at different intervals

## Installation

1. Clone the repository
2. Navigate to the project directory
   ```bash
   cd Lab3
   ```
3. Install dependencies
   ```bash
   composer install
   ```
4. Create a copy of the `.env.example` file
   ```bash
   cp .env.example .env
   ```
5. Generate an application key
   ```bash
   php artisan key:generate
   ```
6. Configure your database in `.env` (SQLite is used by default)
7. Run migrations
   ```bash
   php artisan migrate
   ```
8. Create a storage link
   ```bash
   php artisan storage:link
   ```
9. Start the development server
   ```bash
   php artisan serve
   ```

## Configuration

### Queue Configuration

The application is configured to use the database queue driver. The configuration is in the `.env` file:

```
QUEUE_CONNECTION=database
```

### File Storage Configuration

The application uses the public disk for file storage. The configuration is in the `.env` file:

```
FILESYSTEM_DISK=public
```

## Testing Features

### Testing Post Creation with Image Upload

1. Navigate to `http://localhost:8000/posts`
2. Click on "Create Post"
3. Fill in the form with title, content, and select an image
4. Choose a user from the dropdown
5. Click "Create Post"
6. Verify the post was created with the image displayed

### Testing Post Update with Image Replacement

1. Navigate to an existing post's edit page
2. Change the post details as needed
3. Upload a new image
4. Submit the form
5. Verify the old image was replaced and the post was updated

### Testing Post Deletion

1. Navigate to a post's detail view
2. Click "Delete"
3. Confirm deletion
4. Verify the post is deleted and the associated image is removed from storage

### Testing Queue and Jobs

1. Run the queue worker:
   ```bash
   php artisan queue:work
   ```
2. Dispatch the pruning job manually for testing:
   ```bash
   php artisan tinker
   dispatch(new App\Jobs\PruneOldPostsJob());
   ```
3. Check the logs to verify post deletion:
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Testing Task Scheduling

1. Run the scheduler manually to test:
   ```bash
   php artisan schedule:run
   ```
2. To set up the scheduler on your server, add this cron job:
   ```
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## Advanced Usage

### Customizing the Prune Threshold

The `PruneOldPostsJob` is configured to delete posts older than 2 years. To change this threshold, modify the job class:

```php
// Change this line in app/Jobs/PruneOldPostsJob.php
$twoYearsAgo = Carbon::now()->subYears(2); // Change 2 to your desired value
```

### Regenerating Slugs for Existing Posts

If you need to regenerate slugs for all existing posts:

```bash
php artisan db:seed --class=PostSlugSeeder
```

## Notes

- Make sure your web server has write permissions to the storage directory
- For production, configure a proper queue worker or use Supervisor
- The image functionality uses Laravel's accessor/mutator pattern for clean code
