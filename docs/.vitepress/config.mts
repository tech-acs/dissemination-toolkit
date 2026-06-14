import { defineConfig } from 'vitepress'

export default defineConfig({
  title: "Dissemination Toolkit",
  description: "Census and survey data dissemination tool",
  ignoreDeadLinks: [
    /^https?:\/\/localhost/
  ],

  themeConfig: {
    search: {
      provider: 'local'
    },

    nav: [
      { text: 'Home', link: '/' },
      { text: 'Users', link: '/user/introduction' },
      { text: 'Managers', link: '/manager/introduction' },
    ],

    sidebar: {
      '/user/': [
        { text: 'Introduction', link: '/user/introduction' },
        { text: 'Data explorer', link: '/user/' }, // Searching, pivoting, download, etc.
        { text: 'Visualizations', link: '/user/' }, // Create, publish,
        { text: 'Data stories', link: '/user/' },
        { text: 'Documents', link: '/user/' },
        { text: 'Datasets', link: '/user/' },
      ],

      '/manager/': [
        { text: 'Introduction', link: '/manager/introduction' },
        {
          text: 'Access Control',
          collapsed: true,
          items: [
            { text: 'Users', link: '/manager/access-control/users' },
            { text: 'Roles', link: '/manager/access-control/roles' },
          ]
        },
        {
          text: 'Core Configuration',
          collapsed: true,
          items: [
            { text: 'Area Hierarchy', link: '/manager/core-configuration/area-hierarchy' },
            { text: 'Areas', link: '/manager/core-configuration/areas' },
          ]
        },
        {
          text: 'Abc',
          collapsed: true,
          items: [
            { text: 'Topics', link: '/manager/' },
            { text: 'Indicators', link: '/manager/' },
            { text: 'Dimensions', link: '/manager/' },
            { text: 'Datasets', link: '/manager/' },
          ]
        },
        {
          text: 'Xyz',
          collapsed: true,
          items: [
            { text: 'Visualizations', link: '/manager/' },
            { text: 'Data stories', link: '/manager/' },
          ]
        },
        { text: 'Documents', link: '/manager/announcements' },
        { text: 'Tags', link: '/manager/announcements' },
        { text: 'Announcements', link: '/manager/announcements' },
        { text: 'Organization', link: '/manager/settings' },
      ],
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/tech-acs/dissemination-toolkit' }
    ]
  }
})