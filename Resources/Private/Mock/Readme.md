# Mock Server for Event Submission API

## Requirements
* docker (compose)
* curl, HTTPie or any other tool for HTTP requests

## Usage

### Start Mock Server

```shell
cd Resources/Private/Mock
docker compose up
```
Note: Run `docker compose up -d` in order to detach from the output of the container.

**expected**
```shell
[+] Running 1/1
 ⠿ Container mock-prism-1  Recreated                                                                                                                     0.1s
Attaching to mock-prism-1
mock-prism-1  | [4:20:27 PM] › [CLI] …  awaiting  Starting Prism…
mock-prism-1  | [4:20:29 PM] › [CLI] ✔  success   GET        http://0.0.0.0:4010/event/385598425
mock-prism-1  | [4:20:29 PM] › [CLI] ✔  success   POST       http://0.0.0.0:4010/event/
mock-prism-1  | [4:20:29 PM] › [CLI] ✔  success   PATCH      http://0.0.0.0:4010/event/-1009656260
mock-prism-1  | [4:20:29 PM] › [CLI] ✔  success   DELETE     http://0.0.0.0:4010/event/1120155126
mock-prism-1  | [4:20:29 PM] › [CLI] ✔  success   Prism is listening on http://0.0.0.0:4010
```

### Make API Requests

Open another terminal. 

#### HTTPie
```shell
http http -A bearer --auth 12345 :8080/event/
```
**expected response:**

```shell
HTTP/1.1 200 OK
Access-Control-Allow-Credentials: true
Access-Control-Allow-Headers: *
Access-Control-Allow-Origin: *
Access-Control-Expose-Headers: *
Connection: keep-alive
Content-Length: 412
Content-type: application/json
Date: Tue, 04 Jul 2023 16:27:06 GMT
Keep-Alive: timeout=5
sl-violations: [{"location":["response","body","datetime"],"severity":"Error","code":"format","message":"must match format \"date-time\""},{"location":["response","body","event_end"],"severity":"Error","code":"format","message":"must match format \"date-time\""},{"location":["response","body","organizer_simple"],"severity":"Error","code":"maxLength","message":"must NOT have more than 30 characters"},{"location":["response","body","reference_id"],"severity":"Error","code":"type","message":"must be string"}]

{
    "bodytext": "Do not miss this event! It will be awesome.",
    "country": 13,
    "datetime": "2017-07-21T17:00:00",
    "event_end": "2017-07-21T19:00:00",
    "event_mode": "on_site",
    "location_simple": "A cool venue",
    "organizer_simple": "International Climate Initiative",
    "reference_id": 994432,
    "teaser": "Teaser text for event proposal. The teaser must not  contain any html tags\n",
    "timezone": 1575,
    "title": "A event proposal with title"
}

```
#### `curl`
```shell
curl -H "Authorization: Bearer 56789" http://localhost:8080/event/
```
**expected response**
```shell
{"title":"A event proposal with title","teaser":"Teaser text for event proposal. The teaser must not  contain any html tags\n","datetime":"2017-07-21T17:00:00","event_end":"2017-07-21T19:00:00","timezone":1575,"bodytext":"Do not miss this event! It will be awesome.","event_mode":"on_site","organizer_simple":"International Climate Initiative","location_simple":"A cool venue","reference_id":994432,"country":13}
```
