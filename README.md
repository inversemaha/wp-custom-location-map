# Custom Location Map Pro

**Custom Location Map Pro** is a professional WordPress plugin that allows you to dynamically manage and display multiple locations on a Google Map with custom modals for each marker. All locations are managed through the WordPress admin dashboard using a user-friendly interface. The map is embedded into any page or post using the `[custom_location_map]` shortcode.

---

## 🎯 Purpose

- **Showcase multiple locations:** Perfect for businesses, consultancies, franchises, or NGOs with multiple offices or branches.
- **Dynamic management:** Add, edit, or remove locations via an intuitive admin interface—no code required.
- **Rich location details:** Each marker displays a modal with title, image, address, directions link, and website.
- **Responsive & Modern:** The map and modals are fully responsive and visually appealing.
- **Secure & Maintainable:** Built with WordPress best practices, proper sanitization, and a modular file structure for easy maintenance or extension.

---

## 📁 Plugin Structure

```
custom-location-map/
│
├── custom-location-map.php       # Main plugin loader
│
├── admin/
│   └── admin.php                 # Custom Post Type & meta boxes logic for Locations
│
├── public/
│   └── public.php                # Shortcode and frontend logic
│
├── templates/
│   └── map-modal.php             # HTML template for the map and modal
│
├── assets/
│   ├── admin.js                  # Admin JS for media uploader
│   ├── map.js                    # Frontend map logic
│   └── style.css                 # Frontend styles
│
└── README.md                     # Plugin documentation (this file)
```

---

## 🚀 Installation

### 1. Download or Clone

- **Download:**  
  Download the plugin as a ZIP archive, or
- **Clone:**  
  `git clone https://github.com/inversemaha/custom-location-map.git`

### 2. Upload to WordPress

- Go to your WordPress site’s **Admin Dashboard → Plugins → Add New → Upload Plugin**.
- Upload the `custom-location-map.zip` file, or upload the entire `custom-location-map` folder into `wp-content/plugins/` via FTP.

### 3. Activate the Plugin

- Go to **Plugins**, locate **Custom Location Map Pro**, and click **Activate**.

### 4. Add Locations

- You’ll see a new **Locations** menu in your admin sidebar.
- Click **Add New** to create a new location.
- Fill in all fields:
    - **Title**: Name of the location
    - **Latitude** & **Longitude**: Coordinates for the map marker
    - **Address**: Street address or description
    - **Image**: Upload or select from your media library
    - **Directions Link**: (Optional) Link to Google Maps directions
    - **Website**: (Optional) Website link for this location
- Publish the location. Repeat for all your locations.

### 5. Display the Map

- Add the shortcode `[custom_location_map]` to any page or post where you want the map to appear.
- The map will display all published locations with interactive modals.

---

## ⚙️ Customization

- **Styling:**  
  Modify `assets/style.css` for custom look and feel.
- **Template:**  
  Adjust `templates/map-modal.php` for modal/map HTML structure.
- **Map Functionality:**  
  Enhance `assets/map.js` for further map interactivity.

---

## 🔐 Security & Best Practices

- All user/admin input is sanitized and escaped.
- Image uploads use the WordPress Media Library.
- Only editors/admins can add or edit locations.
- Frontend output is escaped to prevent XSS.

---

## 💡 Advanced

- **Extending Locations:**  
  Add more meta fields in `admin/admin.php` and update output in `templates/map-modal.php` and `assets/map.js`.
- **Custom Map Styles:**  
  Add Google Maps styles in `assets/map.js`.
- **Localization:**  
  Add translation support using WordPress internationalization functions.

---

## 📢 Support

For issues, feature requests, or contributions, open an issue or pull request on [GitHub](https://github.com/inversemaha/custom-location-map).

---

## 📜 License

This plugin is released under the MIT License. See [LICENSE](LICENSE) for details.

---

**Built with ❤️ for WordPress**
