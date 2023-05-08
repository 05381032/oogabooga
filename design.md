# Project Overview

This PHP website will be an ecommerce site to sell handmade star wars memorabilia.

## User Management
Users will be able to login, log out, reset their passwords, and edit their details.

Users will need to store:
- Name
- DOB
- Hashed password
- Access Level (user vs Administrator)
- Status (active or disabled)

## Product Management

Administrators will be able to add, remove, edit products. 

Products will have:
- A name
- A price
- A description
- Quantity

# Behaviour User Journey

```mermaid
journey
title Login / Log off
    section Login
        Load main (home) page: 5: Unauthenticated User
        Enter login details: 5: Unauthenticated User
        Press Login Button: 5: Unauthenticated User
    section Registered
        Perform site Actions:5: Authenticated User
    section Logoff
        Press Logoff Button in Navbar:5: Authenticated User
        Close Browser:5: Unauthenticated User
```

```mermaid
journey
title Contact Us
    section Contact Us
        Load Contact Us page: 5: Any User
        Enter email address : 5: Any User
        Enter message : 5: Any User
        Press Submit Button: 5: Any User
    
```


# Planning Diagram - Wireframes

![Main page wireframe](images/wireframes/main.png)


