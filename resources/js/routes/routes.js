import Cookies from 'js-cookie'
import store from "../store";

const AuthenticatedLayout = () => import('../layouts/Authenticated.vue')
const GuestLayout = () => import('../layouts/Guest.vue');

const PostsIndex = () => import('../views/admin/posts/Index.vue');
const PostsCreate = () => import('../views/admin/posts/Create.vue');
const PostsEdit = () => import('../views/admin/posts/Edit.vue');
const ExercisesIndex = () => import('../views/admin/exercises/Index.vue');
const ExercisesCreate = () => import('../views/admin/exercises/Create.vue');
const ExercisesEdit = () => import('../views/admin/exercises/Edit.vue');
const TasksList = () => import('../views/admin/tasks/index.vue');
const TasksCreate = () => import('../views/admin/tasks/create.vue');
const TasksUpdate = () => import('../views/admin/tasks/update.vue');

/*GESTIONAR JUGADORES*/
const JugadorListAdmin = () => import('../views/admin/jugadoresadmin/indexjugador.vue');
const JugadorCreateAdmin = () => import('../views/admin/jugadoresadmin/createjugador.vue');
const JugadorUpdateAdmin = () => import('../views/admin/jugadoresadmin/indexjugador.vue');

/*VER JUGADORES*/
const JugadorList = () => import('../views/admin/jugadores/indexjugador.vue');

/*GESTIONAR NOTICIAS*/
const NoticiasListAdmin = () => import('../views/admin/futsimvistas/indexnoticia.vue');
const NoticiasCreate = () => import('../views/admin/futsimvistas/createnoticias.vue');
const NoticiasIndividual = () => import('../views/admin/noticias/indexnoticiaindividual.vue');
const NoticiasList = () => import('../views/admin/noticias/indexnoticia.vue');

/*GESTIONAR COMENTARIOS*/
const ComentariosList = () => import('../views/admin/futsimvistas/indexnoticia.vue');
const ComentariosCreate = () => import('../views/admin/futsimvistas/indexnoticia.vue');

/*GESTIONAR PLANTILLAS*/
const PlantillasList = () => import('../views/admin/plantillas/indexplantillas.vue');
const PlantillasListDetalles = () => import('../views/admin/plantillas/detalleplantillas.vue');

/*LISTAR PARTIDOS*/
const PartidosList = () => import('../views/admin/partidos/indexpartido.vue');

/*LISTAR RANKING*/
const RankingList = () => import('../views/admin/ranking/indexranking.vue');
const EditUser = () => import('../views/admin/user/edituser.vue');

function requireLogin(to, from, next) {
    let isLogin = false;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next()
    } else {
        next('/login')
    }
}

function requireAdmin(to, from, next) {
    axios.get('/api/user/rol', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    })
        .then(response => {
            const roles = response.data.roles;
            if (roles.includes('admin')) {
                next();
            } else {
                // Redirigir o devolver una respuesta de acceso denegado
                next('/');
            }
        })
        .catch(error => {
            console.error('Error al obtener los roles del usuario:', error);
            next('/');
        });
}
function guest(to, from, next) {
    let isLogin;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next('/')
    } else {
        next()
    }
}

export default [
    {
        // redirect: {
        //     name: 'admin.index'
        // },
        path: '/',
        // redirect: { name: 'login' },
        component: GuestLayout,
        children: [

            {
                path: '/',
                name: 'home',
                component: () => import('../views/home/index.vue'),
            },
            {
                path: 'posts',
                name: 'public-posts.index',
                component: () => import('../views/posts/index.vue'),
            },
            {
                path: 'posts/:id',
                name: 'public-posts.details',
                component: () => import('../views/posts/details.vue'),
            },
            {
                path: 'category/:id',
                name: 'category-posts.index',
                component: () => import('../views/category/posts.vue'),
            },
            {
                path: 'login',
                name: 'auth.login',
                component: () => import('../views/login/Login.vue'),
                beforeEnter: guest,
            },
            {
                path: 'register',
                name: 'auth.register',
                component: () => import('../views/register/index.vue'),
                beforeEnter: guest,
            },
            {
                path: 'forgot-password',
                name: 'auth.forgot-password',
                component: () => import('../views/auth/passwords/Email.vue'),
                beforeEnter: guest,
            },
            {
                path: 'reset-password/:token',
                name: 'auth.reset-password',
                component: () => import('../views/auth/passwords/Reset.vue'),
                beforeEnter: guest,
            },
        ]
    },
    {
        path: '/admin',
        component: AuthenticatedLayout,
        // redirect: {
        //     name: 'admin.index'
        // },
        beforeEnter: requireLogin,
        meta: { breadCrumb: 'Dashboard' },
        children: [
            {
                name: 'admin.index',
                path: '',
                component: () => import('../views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                name: 'profile.index',
                path: 'profile',
                component: () => import('../views/admin/profile/index.vue'),
                meta: { breadCrumb: 'Profile' }
            },
            {
                name: 'posts.index',
                path: 'posts',
                component: PostsIndex,
                meta: { breadCrumb: 'Posts' }
            },
            {
                name: 'posts.create',
                path: 'posts/create',
                component: PostsCreate,
                meta: { breadCrumb: 'Add new post' }
            },
            {
                name: 'posts.edit',
                path: 'posts/edit/:id',
                component: PostsEdit,
                meta: { breadCrumb: 'Edit post' }
            },
            {
                name: 'exercises',
                path: 'exercises',
                meta: { breadCrumb: 'Exercises' },
                children: [
                    {
                        name: 'exercises.index',
                        path: '',
                        component: ExercisesIndex,
                        meta: { breadCrumb: 'View' }
                    }
                ]
            }, {
                name: 'exercises',
                path: 'exercises',
                meta: { breadCrumb: 'Exercises' },
                children: [
                    {
                        name: 'exercises.index',
                        path: '',
                        component: ExercisesIndex,
                        meta: { breadCrumb: 'View' }
                    },
                    {
                        name: 'exercises.create',
                        path: 'create',
                        component: ExercisesCreate,
                        meta: {
                            breadCrumb: 'Add new exercise',
                            linked: false,
                        }
                    },
                    {
                        name: 'exercises.edit',
                        path: 'edit/:id',
                        component: ExercisesEdit,
                        meta: {
                            breadCrumb: 'Edit exercise',
                            linked: false,
                        }
                    }
                ]
            },
            {
                name: 'tasks',
                path: 'tasks',
                meta: { breadCrumb: 'Tareas' },
                children: [
                    {
                        name: 'tasks.index',
                        path: '',
                        component: TasksList,
                        meta: { breadCrumb: 'Listado tareas' }
                    },
                    {
                        name: 'tasks.create',
                        path: 'create',
                        component: TasksCreate,
                        meta: { breadCrumb: 'Crear tareas' }
                    }, {
                        name: 'tasks.update',
                        path: 'update/:id',
                        component: TasksUpdate,
                        meta: {
                            breadCrumb: 'Updatear tareas',
                            linked: false,
                        }
                    }
                ]
            },
            {
                beforeEnter:requireAdmin,
                name: 'jugadoresadmin',
                path: 'jugadoresadmin',
                meta: { breadCrumb: 'Jugadores' },
                children: [
                    {
                        name: 'jugadoresadmin.indexjugador',
                        path: 'jugadores',
                        component: JugadorListAdmin,
                        meta: { breadCrumb: 'Listar Jugadores' }
                    },
                    {
                        name: 'jugadoresadmin.createjugador',
                        path: 'jugadores/createjugador',
                        component: JugadorCreateAdmin,
                        meta: { breadCrumb: 'Crear Jugador' }
                    }, {
                        name: 'jugadoresadmin.updatejugador',
                        path: 'indexjugador/:id',
                        component: JugadorUpdateAdmin,
                        meta: {
                            breadCrumb: 'Modificar Jugador',
                            linked: false,
                        }
                    }
                ]
            },
            {
                name: 'jugadores',
                path: 'jugadores',
                meta: { breadCrumb: 'Jugadores' },
                children: [
                    {
                        name: 'jugadores.indexjugador',
                        path: '/admin/jugadores',
                        component: JugadorList,
                        meta: { breadCrumb: 'Listar Jugadores' }
                    }
                ]
            },
            {
                beforeEnter:requireAdmin,
                name: 'NoticiasAdmin',
                path: 'futsimvistas',
                meta: { breadCrumb: 'Noticias' },
                children: [
                    {
                        name: 'futsimvistas.indexnoticia',
                        path: 'noticias',
                        component: NoticiasListAdmin,
                        meta: {
                            breadCrumb: 'Listar Noticias',
                            linked: false,
                        }
                    },
                    {
                        name: 'futsimvistas.createnoticia',
                        path: 'noticias/createnoticia',
                        component: NoticiasCreate,
                        meta: { breadCrumb: 'Listar Noticias' }
                    }

                ]
            }, {
                name: 'Noticias',
                path: 'noticias',
                meta: { breadCrumb: 'Noticias' },
                children: [
                    {
                        name: 'noticias.indexnoticia',
                        path: '/admin/noticias',
                        component: NoticiasList,
                        meta: { breadCrumb: 'Listar Noticias' }
                    },
                    {
                        name: 'noticias.indexnoticiaindividual',
                        path: 'noticiaindividual/:id',
                        component: NoticiasIndividual,
                        meta: { breadCrumb: 'Listar Noticias' }
                    }
                ]
            },
            {
                name: 'Comentarios',
                path: 'futsimvistas',
                meta: { breadCrumb: 'Noticias' },
                children: [
                    {
                        name: 'futsimvistas.indexnoticia',
                        path: 'noticias',
                        component: ComentariosList,
                        meta: {
                            breadCrumb: 'Listar Noticias',
                            linked: false,
                        }
                    },
                    {
                        name: 'futsimvistas.createcomentario',
                        path: 'noticias/indexnoticia/:id_noticia',
                        component: ComentariosCreate,
                        props: true,
                        meta: {
                            breadCrumb: 'Listar Noticias',
                            linked: false,
                        }
                    }
                ]
            },
            {
                name: 'plantillas',
                path: 'plantillas',
                meta: {
                    breadCrumb: 'Listar Plantilla',
                },
                children: [
                    {
                        name: 'plantillas.detalleplantillas',
                        path: '/admin/plantillas/misplantillas',
                        component: PlantillasListDetalles,
                        meta: {
                            breadCrumb: 'Mis Plantillas',
                            linked: false,
                        }
                    },
                    {
                        name: 'plantillas.indexplantillas',
                        path: '/admin/plantillas',
                        component: PlantillasList,
                        meta: {
                            breadCrumb: 'Plantillas Rivales',
                            linked: false,
                        }
                    }
                ]
            },
            {
                name: 'partidos.indexpartido',
                path: '/admin/partidos/:plantillaId/:plantillaSeleccionadaId',
                component: PartidosList,
                meta: {
                    breadCrumb: 'Partidos',
                    linked: false,
                }
            },
            {
                name: 'ranking',
                path: 'ranking',
                meta: {
                    breadCrumb: 'Ranking',
                },
                children: [
                    {
                        name: 'ranking.indexranking',
                        path: '/admin/ranking',
                        component: RankingList,
                        meta: {
                            breadCrumb: 'Ranking',
                            linked: false,
                        }
                    }
                ]
            },
            {
                name: 'edituser',
                path: 'user',
                meta: {
                    breadCrumb: 'Editar Usuario',
                },
                children: [
                    {
                        name: 'user.editaruser',
                        path: '/admin/user',
                        component: EditUser,
                        meta: {
                            breadCrumb: 'Editar Usuario',
                            linked: false,
                        }
                    }
                ]
            },
            {
                name: 'categories',
                path: 'categories',
                meta: { breadCrumb: 'Categories' },
                children: [
                    {
                        name: 'categories.index',
                        path: '',
                        component: () => import('../views/admin/categories/Index.vue'),
                        meta: { breadCrumb: 'View category' }
                    },
                    {
                        name: 'categories.create',
                        path: 'create',
                        component: () => import('../views/admin/categories/Create.vue'),
                        meta: {
                            breadCrumb: 'Add new category',
                            linked: false,
                        }
                    },
                    {
                        name: 'categories.update',
                        path: 'update/:id',
                        component: () => import('../views/admin/categories/Edit.vue'),
                        meta: {
                            breadCrumb: 'Edit category',
                            linked: false,
                        }
                    }
                ]
            },

            {
                name: 'permissions',
                path: 'permissions',
                meta: { breadCrumb: 'Permisos' },
                children: [
                    {
                        name: 'permissions.index',
                        path: '',
                        component: () => import('../views/admin/permissions/Index.vue'),
                        meta: { breadCrumb: 'Permissions' }
                    },
                    {
                        name: 'permissions.create',
                        path: 'create',
                        component: () => import('../views/admin/permissions/Create.vue'),
                        meta: {
                            breadCrumb: 'Create Permission',
                            linked: false,
                        }
                    },
                    {
                        name: 'permissions.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/permissions/Edit.vue'),
                        meta: {
                            breadCrumb: 'Permission Edit',
                            linked: false,
                        }
                    }
                ]
            },

            //TODO Organizar rutas
            {
                name: 'roles.index',
                path: 'roles',
                component: () => import('../views/admin/roles/Index.vue'),
                meta: { breadCrumb: 'Roles' }
            },
            {
                name: 'roles.create',
                path: 'roles/create',
                component: () => import('../views/admin/roles/Create.vue'),
                meta: { breadCrumb: 'Create Role' }
            },
            {
                name: 'roles.edit',
                path: 'roles/edit/:id',
                component: () => import('../views/admin/roles/Edit.vue'),
                meta: { breadCrumb: 'Role Edit' }
            },
            {
                name: 'users.index',
                path: 'users',
                component: () => import('../views/admin/users/Index.vue'),
                meta: { breadCrumb: 'Users' }
            },
            {
                name: 'users.create',
                path: 'users/create',
                component: () => import('../views/admin/users/Create.vue'),
                meta: { breadCrumb: 'Add New' }
            },
            {
                name: 'users.edit',
                path: 'users/edit/:id',
                component: () => import('../views/admin/users/Edit.vue'),
                meta: { breadCrumb: 'User Edit' }
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
