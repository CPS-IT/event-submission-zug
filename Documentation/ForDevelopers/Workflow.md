Workflow
========


## Overview

### 1. validate email address

**Endpoint**: `POST /user/sendValidationRequest`

On this request an email with a validation link will be sent to the user. This validation link must be opened in order to prove that a user has access to the given email address.

Your app should then recognize the user and proceed to posting the event. (see: `2. submit event proposal`).

### 2. submit event proposal

**Endpoint**: `POST /event/`

Creates a new event proposal.

It will be persisted as a record in the table `tx_eventsubmission_domain_model_job`. with the status "new". The payload of the request will be contained in the field `payload` of this record.

On success a response containig `id` and `editToken` for this event will be returned.
Any other action relies on this token. It will be sent to the user via email.

The proposal will not be processed before approved by an editor.

### 3. get event proposal
**Endpoint**:  `GET /event/{id}`

Get a single event proposal.

Returns the event proposal or an error if it doesn't exist.


### 4. edit event proposal

**Endpoint**:  `PUT /event/{id}`

Change an existing event proposal.

In case of success, the content of the payload replaces the payload of the existing.
The status of the proposal will be set to "updated". This status requires a new approval by an editor.

If the proposal doesn't exist or can not be edited, an error message is returned.

### 5. withdraw event proposal

**Endpoint**:  `PUT /event/{id}/withdraw`

Withdraw an existing event proposal.

The proposal status will be set to "withdrawn". It can not be edited anymore.
