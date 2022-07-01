login : http://localhost/SPA/login.php
    type: post
    parametros: {
                  "user": varchar,
                  "password": varchar
                 }

USUARIOS : 

	buscar ususario por correo -> http://localhost/SPA/users?correo=david@perezmail.com
	type: get

	REGISTRAR UN USUARIO: http://localhost/SPA/users.php
	type: post 
	parametros: {
    			"tipo": varchar,
    			"nombre": varchar,
    			"correo": varchar,
    			"password": varchar
		    }

	MODIFICAR UN USUARIO : http://localhost/SPA/users.php
	type: put
	parametos : segun se deseen modificar	 		  
                  {   
   		    "id_user": int, -> obligatorio
    		    "tipo": varchar,
     		    "nombre": varchar,
  		    "correo": varchar,
		    "password": varchar 
		   }
	
	ELIMINAR UN USUARIO: 
    	type: delete
	parametros : 
		     {   
		       "correo": varchar, ->obligatorio
   		       "tipo": varchar -> obligatorio
		     }

                
PRODUCTOS : 
     -> REGISTAR UN PRODUTO : http://localhost/SPA/producto.php
          type : post
          parametros: {
                          "categoria": varchar,
                          "nit_proveedor": int,
                          "nombre": varchar,
                          "precio_costo": int,
                          "precio_publico": int,
                          "fecha_entrada": data,
                          "fecha_vencimiento": data,
                          "iva": int
                      }

      -> VER PRODUCTOS: -> obtener un produto por su nombre = http://localhost/SPA/producto?Nameproduct= humectante
                        -> obtener todos los productos = http://localhost/SPA/producto?product=allProducts
           type : get
           
      -> ELIMAR UN PRODUCTO : http://localhost/SPA/producto.php
           type : delete
           parametros: {
                        "nombre": varchar
                        }
                        
      -> MODIFICAR UN PRODUCTO: http://localhost/SPA/producto.php
           type : put
           parametros: dependiendo los que se deseen modificar.
                      {
                      "id_categoria": int,
                      "id_proveedor": int,
                      "nombre": varchar,
                      "precio_costo": int,
                      "precio_publico": int,
                      "fecha_entrada": date,
                      "fecha_vencimiento": date ,
                      "iva": int
                      }
 
COTIZACIONES : 
       -> REGISTAR LA COTIZACION DE UN PRODUCTO : http://localhost/SPA/cotizacion.php
          type: post 
          parametros : {
                        "cantidad": int,
                        "nombreProducto": varchar,
                        "fecha_cotizacion": data,
                        "nombreCliente": varchar,
                        "cedulaCliente": int
                        }
                        
       -> VER COTIZACIONES : ver cotizacion por numero de cedula -> http://localhost/SPA/cotizacion?cedula=1122143111
                             ver toas las cotizaciones registradas -> http://localhost/SPA/cotizacion?cotizaciones=cotizaciones
          type: get

       -> EDITAR UNA COTIZACION:
	  type: put
	  Parametros {
			"id_cotizacion": int -> Obligatorio
                        "cantidad": int,
                        "nombreProducto": varchar

		     }

CATEGORIAS : 
	    ->VER CATEGORIA POR NOMBRE: http://localhost/SPA/categoria?nomCat=Proteinas
	      VER TODAS LAS CATEGORIAS: http://localhost/SPA/categoria?cat=Categorias


	    ->AGREGAR UNA NUEVA CATEGORIA: http://localhost/SPA/categoria.php
	      type: post
	      Parametros : {
			      "nombreCategoria": varchar -> Obligatorio
                              "descripcionCat": varchar
		     	   }

	    ->MODIFICAR CATEGORIA: http://localhost/SPA/categoria.php
	      Type: put
	      Paramaetros: {
			      "Id_categoria": int -> Obligatorio
			      "nombreCategoria": varchar 
                              "descripcionCat": varchar
		     	   }	

	    -> ELIMINAR CATEGORIA: http://localhost/SPA/categoria.php
	       Type: DELETE 
	       Parametros: {
			      "Id_categoria": int -> Obligatorio
		     	   }
