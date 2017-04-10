# Metaverse Leaderboard Project
To access a leaderboard the URL format is <host>/?id=<leaderboardid>

The following API endpoints are available:
## /create.php
Create a new leaderboard, parameters required:
- name: Leaderboard name
- logo: URL to a logo image
- description: Description of the leaderboard

## /create.php
Create a new leaderboard, parameters required:
- name: Leaderboard name
- logo: URL to a logo image
- description: Description of the leaderboard
**Returns an 'apikey' for this database to be used in subsequent calls.**

## /modify.php
Modify an existing leaderboard:
- apikey: API Key for this leaderboard
- name: Leaderboard name
- logo: URL to a logo image
- description: Description of the leaderboard

## /delete.php
Soft Delete existing leaderboard:
- apikey: API Key for this leaderboard

## /update.php
Insert or update a user's score:
- apikey: API Key for this leaderboard
- username: User whose score is being modified.
- increment: Value to add to existing score.
