# Test project on sf4

Aim of this project is to check how fast can be created event registration application on top of sf4.


## project description

Simple application for non-profit organization to simplify participation registering for attenders.

## API

``api/`` - display list of upcomming events.
```json
{
  "metadata": {
    "limit": 10,
    "route": "api_upcomming_events"
  },
  "code": 0,
  "data": {
    "events": {
      "1": {
        "title": "Meetup, September 19 (only 15 places)",
        "id": 1,
        "starts_at": {
          "date": "2019-09-19 16:20:00.000000",
          "timezone_type": 3,
          "timezone": "Europe\/Helsinki"
        },
        "ends_at": {
          "date": "2019-09-20 20:00:00.000000",
          "timezone_type": 3,
          "timezone": "Europe\/Helsinki"
        },
        "description": "Meetup, September 19 (only 15 places)",
        "is_registration_open": true,
        "is_paid": true
      }
    }
  }
}
```
``api/event/{eventId}`` - detailed information about event.
```json
{
  "metadata": {
    "route": "api_event_details"
  },
  "code": 0,
  "data": {
    "title": "Meetup, September 19 (only 15 places)",
    "id": 1,
    "starts_at": {
      "date": "2019-09-19 16:20:00.000000",
      "timezone_type": 3,
      "timezone": "Europe\/Helsinki"
    },
    "ends_at": {
      "date": "2019-09-20 20:00:00.000000",
      "timezone_type": 3,
      "timezone": "Europe\/Helsinki"
    },
    "description": "Meetup, September 19 (only 15 places)",
    "is_registration_open": true,
    "is_paid": true,
    "attenders": [
      "incognito",
      "incognito",
      "sdfgdf gfsdgsdfg"
    ]
  }
}
```

## What already can be done:
- happening listing
- apply to happening.
- simple admin panel with approve/reject process.

## todo

- process and communicate with attender.
- payment module.
- gdpr ready
