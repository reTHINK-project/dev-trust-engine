# dev-trust-engine

The Trust Engine can be seen as a service providing information regarding trust in a communication peer, structured in several quantities or vectors that may  be combined or grouped to certain levels. But the decision who is trusted and who is not trusted is very personal and should be up to the user.

The Trust Engine is designed as a personalized service, for which users may have their own preferences regarding trust.

The 1st release will consider use of white- and blacklist.

## API

The Trust Engine can be invoked in a SaaS manner by:
-	an application that runs on the client side (for instance a communication application);
-	a service that runs on a network-based infrastructure (for instance the Discovery service).

The basic REST APIs are:
- _getTrustInfo_ to get information about the trustworthiness of an peer,
- _addToWhiteList_ to add a contact to user's white list,
- _addToBlackList_ to add a contact to user's black list.

These 3 APIs take 2 parameters as input:
- the GUID of the user whose accont is considered,
- the userID of the peer whose trustworthiness is at stake.

The _getTrustInfo_ API returns:

| value | result          |
|------:|-----------------|
|  -1   | unknown GUID    |
|   0   | unlisted URL    |
|   1   | blacklisted URL |
|   2   | whitelisted URL |

_NB. Obviously the same identifier may not be on both white- and blacklist of the same user!_

## Web interface

The Trust Engine provides online user interface enabling users to create and manage their account.
