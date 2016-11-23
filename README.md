# dev-trust-engine

The Trust Engine can be seen as a service providing information regarding trust in a communication peer, structured in several quantities or vectors that may  be combined or grouped to certain levels. But the decision who is trusted and who is not trusted is very personal and should be up to the user.

The Trust Engine is designed as a personalized service, for which users may have their own preferences regarding trust.

The 1st release will consider use of white- and blacklist.

## API

The Trust Engine can be invoked in a SaaS manner by:
-	an application that runs on the client side (for instance a communication application);
-	a service that runs on a network-based infrastructure (for instance the Discovery service).

The basic REST API are:
- _getTrustInfo_ to get information about the trustworthiness of an Identity (userID or GUID)
- _addToWhiteList_ to add a contact (identified by userID or GUID) to user's white list
- _addToBlackList_ to add a contact (identified by userID or GUID) to user's black list

_NB. Obviously the same identifier may not be on both white- and blacklist of the same user!_

## Web interface

The Trust Engine provides online user interface enabling users to create and manage their account.
