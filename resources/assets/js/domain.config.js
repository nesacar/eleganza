let baseUrl = '';
if(process.env.NODE_ENV === 'production'){
    baseUrl = 'http://eleganza.mia.rs/';
}else{
    baseUrl = 'http://localhost/eleganza/public/';
}

export const domain = baseUrl;
