# Introduction

The management dashboard is where authorised users create, manage, and publish content on the Dissemination Toolkit. Access is controlled through a role-based permission system.

Manager accounts are usually created during setup/deployment but can also be created on the command line (CLI) at any time afterwards.

## Logging in

Click the **Login** button in the top-right corner of the public site (landing page). After signing in with your credentials, you are redirected to the management dashboard at `/manage/home`.

## Permissions model

The toolkit uses granular permissions. Each action (create, edit, delete, publish) on each content type (topics, indicators, dimensions, datasets, stories, visualizations, documents) is controlled by a specific permission. Users are assigned to **roles**, and roles are granted permissions.

A **Super Admin** role bypasses all permission checks and has access to everything, including user management, role configuration, area management, and organization settings.

## Dashboard overview

The management home page presents a grid of cards organized into two groups:

### Data

- **Manage topics** — organize indicators, visualizations, and stories into semantic categories
- **Manage indicators** — create, update, and assign indicators to topics
- **Manage dimensions** — define descriptive attributes used to slice and dice data
- **Manage datasets** — import and manage collections of tabular data

### Content

- **Manage visualizations** — create, customize, and share interactive data visualizations
- **Manage stories** — build data-driven narratives using the story designer
- **Manage documents** — upload census tables with Dublin Core metadata
- **Manage tags** — Tags help you categorize and filter artefacts for easier discovery and organization.

## Navigation

The top navigation bar provides quick links organized into dropdowns:

### Main navigation

| Menu | Items |
|---|---|
| **Data** | Topics, Indicators, Dimensions, Datasets |
| **Content** | Visualizations, Data stories, Documents, Tags |

### Manage dropdown

The **Manage** dropdown (visible only to Super Admin users) provides access to advanced configuration:

- **Access Control** — Users and Roles
- **Core Configuration** — Area Hierarchy and Areas
- **Announcements**
- **Settings** — Organisation details and branding
