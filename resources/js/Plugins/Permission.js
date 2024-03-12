import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
const permissions = computed(() => usePage().props.user_permissions.permissions);

let Permissions = {
  	install(app, options) {
	    app.config.globalProperties.$user = {
			can(permission) {
				return permissions && permissions.value.includes(permission)? true : false;
			},
			// if any one permission match it will return false
			// var somePermissions is array of permissions
			canSome(somePermissions){
				return permissions && permissions.value.some(permission => somePermissions.includes(permission)) ? true : false;
			}
	    }
  	}
};

export default Permissions