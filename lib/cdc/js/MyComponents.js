const componentOpts = {

    name : 'MyComponent',
    data() {
        return {
            msg : "Component CDC"
        }
    },
    template : `
    <div>{{msg}}</div>
    <button @click="test">Click</button>
    ` ,
    
    props:{

    },
    computed: {

    },
    methods : {
        test() {
            console.log('button Click');
        }
    }
}