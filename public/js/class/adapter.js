class Adapter {
    Context;
    fetch_url;
    callbacks;

    dataArr = [];
    is_fetching = false;
    constructor(Context,fetch_url,callbacks){
        this.Context = Context;
        this.fetch_url = fetch_url;
        this.callbacks = callbacks;

        this.fetchData(this.setData,this.callbacks.setComponent,this.Context);
    }

    fetchData(setData,setComponent,Context){
        this.is_fetching = true;
            this.callbacks.onFetching();
        if(this.fetch_url==null){
            
            this.callbacks.completeFetching();
            return;
        }
        $.ajax({
            url: this.fetch_url,
            type: 'GET', // or 'GET' depending on your request
            headers: {
                'Authorization': 'Bearer '+this.Context.apiToken // Example for Authorization header
            },
            
            success: function(res) {
                this.is_fetching=false;
                if(res){
                    this.fetch_url = res.next_page_url;
                    let data = res.data;
                    setData(data,setComponent,Context);
                    
                }
            },
            error: function(xhr, status, error) {
                if(xhr.status==401){
                    
                }
            }
        });
    }

	setData(data,setComponent,Context){
        //this.callbacks.completeFetching();
        data.map((d,index)=>{
            setComponent(Context,d);
        })
    }

    
}