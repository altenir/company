// @ts-nocheck
window.Echo.channel('laravel_database_post-created').listen('.App\\Events\\PostCreated', (e)=>{
    console.log(e)
    console.log(e.post)
})