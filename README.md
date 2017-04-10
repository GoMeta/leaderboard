# Metaverse Leaderboard Project
To access a leaderboard the URL format is *host*/?id=*leaderboardid*

The following API endpoints are available:
## /api/create.php
Create a new leaderboard, parameters required:
- name: Leaderboard name
- logo: URL to a logo image
- description: Description of the leaderboard

## /api/create.php
Create a new leaderboard, parameters required:
- name: Leaderboard name
- logo: URL to a logo image
- description: Description of the leaderboard

*Returns an 'apikey' for this database to be used in subsequent calls.*

## /api/modify.php
Modify an existing leaderboard:
- apikey: API Key for this leaderboard
- name: Leaderboard name
- logo: URL to a logo image
- description: Description of the leaderboard

## /api/delete.php
Soft Delete existing leaderboard:
- apikey: API Key for this leaderboard

## /api/update.php
Insert or update a user's score:
- apikey: API Key for this leaderboard
- username: User whose score is being modified.
- increment: Value to add to existing score.
