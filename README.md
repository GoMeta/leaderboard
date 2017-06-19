# Metaverse Leaderboard Sample Project
This repository contains a simple leaderboard service that demonstrates how easy it is to integrate Metaverse with third-party APIs. This is a simple service, intended to be used as a tool to understand, in a practical way, how to interface between Metaverse and your custom service.

## Hosted leaderboard
If you would like you use leaderboards within your own dimension, you can either clone this project and deploy on your own host, or you can access our hosted leaderboard at `http://leaderboards.metaverseapp.io/`. Feel free to use this in production, however we cannot guarentee that it will be free from breaking changes.

To access a leaderboard the URL format is http://*host*/?id=*leaderboard_id*

## Implementing a leaderboard in your dimension
Leaderboards must be created manually, by making a POST request to `http://leaderboards.metaverseapp.io/api/create.php`. This can be done via the command line:

```
curl -X POST http://leaderboards.metaverseapp.io/api/create.php -H 'content-type: application/x-www-form-urlencoded' -d 'name=NAME&logo=URL&description=DESCRIPTION'
```

A successful request will return an API key to be used in subsequent calls.

The leaderboard is then updated by making a POST request to `http://leaderboards.metaverseapp.io/api/update.php`. To configure Metaverse to update your leaderboard, you must use the Javascript sandboxes to make an update request in response to the event you would like to score. This can be done by hooking into the event system within your dimension to execute custom code in response to events.

If you would like to update a leaderboard in response to an event, such as an experience being completed in your dimension, register a new event handler in the "Events" page with the following options:

- Display name: `Increment leaderboard`
- Description: `Increment a user's rank on the leaderboard when they complete an experience`
- Event name: `experience_completed`
- Direct object: `*`
- Indirect object: `*`
- Code:
```
const user = await Meta.contexts.loadUser(Meta.data.event.subject);

Meta.actions.post('http://leaderboards.metaverseapp.io/api/update.php', {
  method: 'post',
  headers: {
    Accept: 'application/x-www-form-urlencoded',
    'Content-Type': 'application/x-www-form-urlencoded',
  },
  body: `apikey=YOUR_API_KEY&username=${user.name}&increment=1`
});
```

You can substitute `experience_completed` with any event. For example, if you wanted to increment the leaderboard every time a user received an item such as a coin, you would create an event handler to listen for `item_received` events, with the direct object set as the ID of the item you are tracking.

The following API endpoints are available:
## /api/create.php
Create a new leaderboard, parameters required:
- **name:** Leaderboard name
- **logo:** URL to a logo image
- **description:** Description of the leaderboard

 -*Returns an 'apikey' for this database to be used in subsequent calls.*

## /api/modify.php
Modify an existing leaderboard:
- **apikey:** API Key for this leaderboard
- **name:** Leaderboard name
- **logo:** URL to a logo image
- **description:** Description of the leaderboard

## /api/delete.php
Soft Delete existing leaderboard:
- **apikey:** API Key for this leaderboard

## /api/update.php
Insert or update a user's score:
- **apikey:** API Key for this leaderboard
- **username:** User whose score is being modified.
- **increment:** Value to add to existing score.
