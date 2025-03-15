import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'ProjectManagement',
      component: () => import('../views/Ecommerce.vue'),
      meta: {
        title: 'Project Management',
        requiresAuth: true,
      },
    },
    {
      path: '/calendar',
      name: 'Calendar',
      component: () => import('../views/Others/Calendar.vue'),
      meta: {
        title: 'Calendar',
      },
    },
    {
      path: '/profile',
      name: 'Profile',
      component: () => import('../views/Others/UserProfile.vue'),
      meta: {
        title: 'Profile',
      },
    },
    {
      path: '/form-elements',
      name: 'Form Elements',
      component: () => import('../views/Forms/FormElements.vue'),
      meta: {
        title: 'Form Elements',
      },
    },
    {
      path: '/companies',
      name: 'Company List',
      component: () => import('../views/Tables/CompanyTables.vue'),
      meta: {
        title: 'Company List',
      },
    },
      {
          path: '/company/create',
          name: 'Create Company',
          component: () => import('../views/Forms/CreateCompanyForm.vue'),
          meta: {
              title: 'Create Company',
          },
      },
      {
          path: '/projects',
          name: 'Project List',
          component: () => import('../views/Tables/ProjectTables.vue'),
          meta: {
              title: 'Project List',
          },
      },
      {
          path: '/project/create',
          name: 'Create Project',
          component: () => import('../views/Forms/CreateProjectForm.vue'),
          meta: {
              title: 'Create Project',
          },
      },
    {
      path: '/signin',
      name: 'Signin',
      component: () => import('../views/Auth/Signin.vue'),
      meta: {
        title: 'Signin',
      },
    },
    {
      path: '/signup',
      name: 'Signup',
      component: () => import('../views/Auth/Signup.vue'),
      meta: {
        title: 'Signup',
      },
    },
  ],
})

router.beforeEach((to, from, next) => {
  document.title = `DevPM ${to.meta.title}`
  next()
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('userToken');
    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/signin');
    } else {
        next();
    }
});

export default router
