# Animated Testimonials Widget

A beautiful, animated testimonials slider component converted from React to work with HTML, CSS, and jQuery for WordPress/Elementor.

## Features

-   **Smooth Animations**: CSS transitions with jQuery-powered interactions
-   **Responsive Design**: Works perfectly on all device sizes
-   **Autoplay Support**: Optional autoplay with customizable speed
-   **Word-by-word Animation**: Testimonial quotes animate word by word
-   **Keyboard Navigation**: Arrow key support for accessibility
-   **Touch-friendly**: Mobile-optimized navigation
-   **Elementor Integration**: Seamlessly integrates with Elementor page builder

## What Was Converted

### From React Component Features:

-   ✅ **Framer Motion animations** → CSS transitions + jQuery animations
-   ✅ **React useState hooks** → jQuery state management
-   ✅ **Tabler icons** → SVG icons
-   ✅ **React useEffect** → jQuery event handlers
-   ✅ **Component props** → Elementor widget controls
-   ✅ **TypeScript types** → PHP/JavaScript validation

### Animation Features:

-   ✅ **Image stacking with random rotations**
-   ✅ **Scale and opacity transitions**
-   ✅ **Bounce effect on active image**
-   ✅ **Word-by-word text animation**
-   ✅ **Smooth content transitions**
-   ✅ **Navigation button hover effects**

## Files Created

```
decent-elements/
├── includes/widgets/
│   └── animated-testimonials.php          # Elementor widget class
├── assets/
│   ├── css/
│   │   └── animated-testimonials.css      # All animations & responsive styles
│   └── js/
│       └── animated-testimonials.js       # jQuery functionality
└── demo.html                              # Standalone demo page
```

## Installation

1. **Add the widget** to your Elementor widgets by including it in `class-widget-manager.php`
2. **Register assets** in your main plugin file
3. **Test the component** using the included `demo.html` file

## Usage

### In Elementor

1. Add the "Animated Testimonials" widget to your page
2. Configure testimonials in the widget settings:
    - Add testimonial quotes
    - Set names and designations
    - Upload images
    - Enable/disable autoplay
3. Customize styling using Elementor's style controls

### Standalone HTML

Open `demo.html` in your browser to see the component in action.

## Technical Implementation

### CSS Architecture

-   **Mobile-first responsive design**
-   **CSS Grid for layout**
-   **CSS transforms for animations**
-   **CSS custom properties for theming**
-   **Intersection Observer for performance**

### jQuery Features

-   **Class-based architecture**
-   **Event delegation**
-   **Smooth state transitions**
-   **Accessibility support**
-   **Performance optimizations**

### WordPress/Elementor Integration

-   **Elementor widget controls**
-   **Asset enqueueing**
-   **Widget categories**
-   **Style and script dependencies**

## Customization

### CSS Variables

```css
.decent-animated-testimonials {
	--animation-duration: 0.4s;
	--autoplay-speed: 5000ms;
	--border-radius: 24px;
}
```

### JavaScript Configuration

```javascript
$(".decent-animated-testimonials").decentAnimatedTestimonials({
	autoplay: true,
	autoplaySpeed: 5000,
	pauseOnHover: true,
});
```

## Browser Support

-   ✅ Chrome 60+
-   ✅ Firefox 55+
-   ✅ Safari 12+
-   ✅ Edge 79+
-   ✅ iOS Safari 12+
-   ✅ Android Chrome 60+

## Performance Features

-   **Intersection Observer** for viewport-based autoplay
-   **Efficient DOM manipulation**
-   **CSS transforms for GPU acceleration**
-   **Debounced event handlers**
-   **Conditional asset loading**

## Accessibility

-   ✅ **Keyboard navigation** (Arrow keys)
-   ✅ **ARIA labels** on navigation buttons
-   ✅ **Focus management**
-   ✅ **Screen reader support**
-   ✅ **Reduced motion support** (respects `prefers-reduced-motion`)

## Migration Notes

### Key Differences from React Version:

1. **State Management**: React's `useState` → jQuery's DOM data attributes
2. **Animations**: Framer Motion → CSS transitions + jQuery
3. **Component Lifecycle**: React hooks → jQuery ready/init methods
4. **Props**: React props → Elementor widget controls
5. **Type Safety**: TypeScript → PHP validation + JavaScript checks

### Maintained Features:

-   All visual animations and effects
-   Responsive behavior
-   Autoplay functionality
-   Navigation controls
-   Word-by-word text animation

## Demo

Visit `demo.html` to see the component in action with sample testimonials.

The component perfectly replicates the original React functionality while being optimized for WordPress/Elementor environments.
