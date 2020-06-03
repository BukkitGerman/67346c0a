# 67346c0a

A 67346c0a Projekt.

---
## TODO

- Implement Teamspeak 3 Framework
- Add PhP Functions
- Build the Site Skeleton

---
### Site Structure

- Home | TS3 Server Status in Sidebar
- Changelog
	- Showes the Changes on Our Server.
- News
	- Showes the News.
- Requests (Only Useable for Registered users)
	- Entbann Request
	- Request to get a own Teamspeak channel
	- Application Request (if is Open, Normaly Closed)
- Disscussion (Only Useable for Registered users)
	- A Disscussion for Registered users (A Chat)
- Administration Page (Only Visibil for Admin Users)
	- Showes Banned Players
	- Showes a Form to Update User Permission
- Profile Page (Only Visibil for Registered users)
- Login / Register | Logout (When user is Logged in)

---
### Database Structure

#### Tables

- users
	- id (Primary Key, INTEGER, AUTOINCREMENT)
	- username (VARCHAR(64))
	- email (VARCHAR(255))
	- password (VARCHAR(255))
	- created_at TIMESTAMP

	```
	 CREATE TABLE IF NOT EXISTS users(
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		username VARCHAR(64) NOT NULL,
		email VARCHAR(255) NOT NULL, 
		passwort VARCHAR(255) NOT NULL,
		created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)
    ``
- permissions
	- id (Primary Key, INTEGER, AUTOINCREMENT)
	- uid (INTEGER)
	- permission (INTEGER)
	- developer (INTEGER)

	```
	CREATE TABLE IF NOT EXISTS permissions(
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		uid INTEGER NOT NULL,
		permission INTEGER NOT NULL, 
		developer INTEGER NOT NULL)
	```

- changelog (In Contruction)

- news (In Contruction)

- disscussion (In Contruction)


	


---
### PHP Functions

- showNavigation($aktive)
	- Showes the Navigationbar with the Active tab.

- showSidebar()
	- Showes the Sidebar

- showFooter()
	- Showes the footer with Copyright. Includes a link to the Impressum

---
### Functionality

- Teamspeak Link
	- Link Teamspeak Groups with Page Permission