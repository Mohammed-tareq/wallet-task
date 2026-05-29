after read the task in first time i think user is auth and make payment or send many by wallet and 
we have two way of wallest so i think may be the system add now wallet in fucture so i using factory method patten so the user sotry is ,

user should login.
user should select the wallet and add the  amount and currency and account number.

in this end point the system is check request and  call service this service in run event 
the event name is WalletWebhookCreateEvent and this event call listenerin this listener i using pakage called spatie/laravel-webhook-server
this package is make the system send webhook (like the test want the data is send to my system by webhook) and run the second event
name is WalletWebhookReceiveEvent this event call listener and in this listener  send notifiction to the system to make it recive the webhok

after the system revice the webhook it run function that get the data from the web hook and chach it to save the data form repeat
and after that the system is convert the webhook data to the format that i want and save it in database.

=>the problem ( i think becouse i using pakage send webhook to my system  so the system cant get the usr authantication so this is the problem ).
and after that i using pakage called "spatie/array-to-xml" this pakage it return the daa i saved in db to xml.


=> so the secund problem and it is the main i found on xml response should return receive and sender data 
so the don't under stand the task in true way ( if the tesk need to return sender and receive so the task like channal
when sender send  money show revice to another user).
 so i fixed it by add the sender and receive data in database and 
return it in xml response but i think this is not the best way to do it.