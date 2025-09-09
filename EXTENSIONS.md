# Extensions System Documentation

## Overview

The Extensions system for Decent Elements provides a way to enable/disable additional functionality beyond the core widgets. This system follows the same design pattern as the Widgets page but is specifically designed for managing optional features and addons.

## Architecture

### Backend (PHP)

-   **Extension Manager**: `includes/class-extension-manager.php`
-   **REST API**: `includes/admin/Admin_Panel_API.php` (extension endpoints)
-   **Extension Files**: `includes/extensions/` directory

### Frontend (React)

-   **Extensions Page**: `src/Pages/Extensions.jsx`
-   **Data Source**: `src/data/widgets.json` (extensions array)
-   **Routing**: Updated in `App.jsx` and `Menu.jsx`

## Components

### 1. Extension Manager (`class-extension-manager.php`)

```php
class Decent_Elements_Extension_Manager
{
    // Manages loading, enabling/disabling extensions
    // Stores settings in 'decent_elements_extension_settings' option
    // Autoloads enabled extensions on init
}
```

### 2. REST API Endpoints

-   `GET /wp-json/decent-elements/v1/extensions/` - Fetch extension settings
-   `POST /wp-json/decent-elements/v1/extensions/` - Save extension settings

### 3. Extensions Page (React)

-   Grid layout similar to Widgets page
-   Real-time toggle switches
-   Auto-save functionality with debouncing
-   Loading states and error handling
-   No filtering/search (as requested)

## Available Extensions

### Core Extensions

1. **Custom CSS** (`custom-css`)

    - Adds custom CSS capability
    - Default: Disabled

2. **Sticky Column** (`sticky-column`)

    - Makes columns sticky on scroll
    - Default: Disabled

3. **Wrapper Link** (`wrapper-link`)

    - Makes entire sections/columns clickable
    - Default: Disabled

4. **Mouse Effects** (`decent-elements-mouse-effects`)

    - Advanced cursor effects
    - Default: Enabled

5. **Scroll Effects** (`decent-elements-scroll-effects`)

    - Scroll-triggered animations
    - Default: Enabled

6. **Advanced Animations** (`decent-elements-advanced-animations`)
    - Extended animation library
    - Default: Disabled

## Data Storage

### Database

Extensions settings are stored in WordPress options table:

-   Option name: `decent_elements_extension_settings`
-   Format: `{ "extension-id": true/false, ... }`

### JSON Configuration

Extensions data is defined in `src/data/widgets.json`:

```json
{
	"extensions": [
		{
			"id": "extension-id",
			"name": "Extension Name",
			"enabled": false,
			"icon": "🎯",
			"link": "https://documentation-url.com"
		}
	]
}
```

## Adding New Extensions

### Step 1: Create Extension File

Create new file in `includes/extensions/my-extension.php`:

```php
<?php
class Decent_Elements_My_Extension
{
    public function __construct()
    {
        // Add hooks and functionality
    }
}
```

### Step 2: Register in Extension Manager

Add to `$extensions` array in `class-extension-manager.php`:

```php
'my-extension' => [
    'name' => 'My Extension',
    'class' => 'Decent_Elements_My_Extension',
    'file' => 'my-extension.php',
    'default' => false
]
```

### Step 3: Update JSON Data

Add to `widgets.json` extensions array:

```json
{
	"id": "my-extension",
	"name": "My Extension",
	"enabled": false,
	"icon": "🚀",
	"link": "https://docs.com/my-extension"
}
```

## Features

### User Experience

-   ✅ Smooth fade-in animations
-   ✅ Real-time toggle feedback
-   ✅ Auto-save with visual indicators
-   ✅ Error handling and notifications
-   ✅ Responsive design
-   ✅ Consistent UI with Widgets page

### Technical Features

-   ✅ REST API integration
-   ✅ Database persistence
-   ✅ Extension autoloading
-   ✅ Class-based extension architecture
-   ✅ Proper WordPress hooks integration
-   ✅ Error logging and debugging

## Integration

The Extensions system is fully integrated into the Decent Elements admin panel:

-   Navigation menu includes "Extensions" tab
-   Same design language as Widgets page
-   Uses existing Toast notification system
-   Follows WordPress coding standards
-   Implements proper permission checks

## Performance

-   Extensions are only loaded when enabled
-   Lazy loading of extension files
-   Debounced API calls for settings
-   Minimal database queries
-   Optimized React rendering
