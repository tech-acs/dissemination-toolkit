# Roles

Roles group permissions together so they can be assigned to users. Accessible from the management **Manage** dropdown under **Access Control → Roles** (Super Admin only).

## Creating a role

1. Go to the Roles page from the management admin menu
2. Enter a **Name** for the role in the form at the top of the page
3. Click **Create**
4. The new role appears in the roles table below

## Editing a role (permission matrix)

1. Click **Edit** next to a role
2. The page displays a permission matrix with all available permissions grouped by resource:

| Resource | Permissions |
|---|---|
| **Visualizations** | create, edit, publish-and-unpublish, delete |
| **Stories** | create, edit, publish-and-unpublish, delete |
| **Topics** | create, edit, delete |
| **Indicators** | create, edit, delete |
| **Dimensions** | create, edit, delete, manage-values |
| **Datasets** | create, edit, import, publish-and-unpublish, delete |
| **Documents** | create, edit, delete, publish-and-unpublish |
| **Reviews** | approve |

3. Check the boxes for each permission you want to grant
4. Click **Update** to save

## Deleting a role

1. Click **Delete** next to a role
2. Confirm in the dialog
3. The **Super Admin** role cannot be deleted

Each role row also shows the number of assigned permissions and users.
