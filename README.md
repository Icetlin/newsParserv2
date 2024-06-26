# News Parser Application

## Overview
This application is designed to parse, store, and display news articles from various sources. The backend is built with Symfony and the frontend uses Vue 3 with Pinia for state management.

## Features
1. **News Pagination:**
   - Infinite scroll pagination with adjustable number of items per page via the web interface.
   
2. **Data Refresh:**
   - Automatic data refresh every N seconds, configurable through the web interface.
   
3. **News Highlighting:**
   - Green highlight for increased rating, red highlight for decreased rating.
   
4. **News Deletion:**
   - Ability to delete news articles from the main list.
   
5. **News Parsing:**
   - Parses the first 15 news articles from rbk.ru and stores them in the database.
   - Parsing can be triggered from the admin panel (EasyAdmin).
   
6. **Random Rating:**
   - Each news article is assigned a random rating between 1 and 10.
   
7. **API:**
   - Provides endpoints to retrieve news articles and update their ratings.
   - News list in JSON:API format with text truncated to 200 characters, rating value, and link to full article. Full articles include images if available.

## Implementation Details

### Backend
- **Framework:** Symfony
- **Database:** PostgreSQL
- **API:** API Platform

### Frontend
- **Framework:** Vue 3
- **State Management:** Pinia
- **Language:** TypeScript

### Design Patterns
- **Factory Pattern:** Used to create parsers for specific websites, facilitating the addition of new news sources.

## Installation
1. Clone the repository.
2. Set up the environment variables.
3. Run database migrations.
4. Start the development server.

