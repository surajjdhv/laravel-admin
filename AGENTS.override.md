## Docker Setup

You are already inside the Docker container, so there’s no need to use Sail commands. Run commands like `php`, `composer`, etc. directly.

## Post-Change Checklist

Since this application uses roles, permissions, and activity logging, review your changes to determine whether:
- Any new permissions need to be added to the seeder, and/or
- An activity log entry should be created for the changes made.
