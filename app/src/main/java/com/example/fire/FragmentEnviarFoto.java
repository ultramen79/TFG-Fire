package com.example.fire;

import android.annotation.TargetApi;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.media.MediaScannerConnection;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.provider.MediaStore;
import android.provider.Settings;
import android.support.annotation.NonNull;
import android.support.annotation.RequiresApi;
import android.support.v13.app.FragmentCompat;
import android.support.v4.app.Fragment;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.Toast;
import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import static android.Manifest.permission.CAMERA;
import static android.Manifest.permission.WRITE_EXTERNAL_STORAGE;
import static com.example.fire.MainActivity.ip;


public class FragmentEnviarFoto extends Fragment implements FragmentCompat.OnRequestPermissionsResultCallback {

        private OnFragmentInteractionListener mListener;

        private String path;//almacena la ruta de la imagen
        Bitmap bitmap;

        private final int MIS_PERMISOS = 100;
        private static final int COD_SELECCIONA = 10;
        private static final int COD_FOTO = 20;

        EditText campoNombre;
        Button botonRegistro,btnFoto;
        ImageView imgFoto;
        ProgressDialog progreso;

        RelativeLayout layoutRegistrar;
        StringRequest stringRequest;
        
        public FragmentEnviarFoto() {
            // Required empty public constructor
        }

        // TODO: Rename and change types and number of parameters
        public static FragmentEnviarFoto newInstance() {
            FragmentEnviarFoto fragment = new FragmentEnviarFoto();;
            return fragment;
        }

        @Override
        public void onCreate(Bundle savedInstanceState) {
            super.onCreate(savedInstanceState);
        }

        @Override
        public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
            View vista=inflater.inflate(R.layout.fragment_enviar_foto, container, false);
            campoNombre= (EditText) vista.findViewById(R.id.campoNombre);
            botonRegistro= (Button) vista.findViewById(R.id.btnEnviar);
            btnFoto=(Button)vista.findViewById(R.id.btnFoto);
            imgFoto=(ImageView)vista.findViewById(R.id.imgFoto);
            layoutRegistrar= (RelativeLayout) vista.findViewById(R.id.idLayoutRegistrar);

            //Permisos
            if(solicitaPermisosVersionesSuperiores()){
                btnFoto.setEnabled(true);
            }else{
                btnFoto.setEnabled(false);
            }

            botonRegistro.setOnClickListener(new View.OnClickListener() {
                @RequiresApi(api = Build.VERSION_CODES.M)
                @Override
                public void onClick(View view) {
                    cargarWebService();
                }
            });

            btnFoto.setOnClickListener(new View.OnClickListener() {
                @RequiresApi(api = Build.VERSION_CODES.M)
                @Override
                public void onClick(View view) {
                    mostrarDialogOpciones();
                }
            });
            return vista;
        }

        @RequiresApi(api = Build.VERSION_CODES.M)
        private void mostrarDialogOpciones() {
            final CharSequence[] opciones={"Elegir de Galeria","Cancelar"};
            final AlertDialog.Builder builder=new AlertDialog.Builder(getContext());
            builder.setTitle("Elige una Opción");
            builder.setItems(opciones, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    if (opciones[i].equals("Elegir de Galeria")){
                        Intent intent=new Intent(Intent.ACTION_PICK,
                                MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                        intent.setType("image/");
                        startActivityForResult(intent.createChooser(intent,"Seleccione"),COD_SELECCIONA);
                    }else{
                        dialogInterface.dismiss();
                    }
                }
            });
            builder.show();
        }

        @RequiresApi(api = Build.VERSION_CODES.M)
        @Override
        public void onActivityResult(int requestCode, int resultCode, Intent data) {
            super.onActivityResult(requestCode, resultCode, data);

            switch (requestCode){
                case COD_SELECCIONA:
                    Uri miPath=data.getData();
                    imgFoto.setImageURI(miPath);
                    try {
                        bitmap=MediaStore.Images.Media.getBitmap(getContext().getContentResolver(),miPath);
                        imgFoto.setImageBitmap(bitmap);
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                    break;
                case COD_FOTO:
                    MediaScannerConnection.scanFile(getContext(), new String[]{path}, null,
                            new MediaScannerConnection.OnScanCompletedListener() {
                                @Override
                                public void onScanCompleted(String path, Uri uri) {
                                    Log.i("Path",""+path);
                                }
                            });
                    bitmap= BitmapFactory.decodeFile(path);
                    imgFoto.setImageBitmap(bitmap);
                    break;
            }
            bitmap=redimensionarImagen(bitmap,600,800);
        }

        private Bitmap redimensionarImagen(Bitmap bitmap, float anchoNuevo, float altoNuevo) {
            int ancho=bitmap.getWidth();
            int alto=bitmap.getHeight();
            if(ancho>anchoNuevo || alto>altoNuevo){
                float escalaAncho=anchoNuevo/ancho;
                float escalaAlto= altoNuevo/alto;
                Matrix matrix=new Matrix();
                matrix.postScale(escalaAncho,escalaAlto);
                return Bitmap.createBitmap(bitmap,0,0,ancho,alto,matrix,false);
            }else{
                return bitmap;
            }
        }


        //Permisos
        private boolean solicitaPermisosVersionesSuperiores() {
            if (Build.VERSION.SDK_INT<Build.VERSION_CODES.M){//validamos si estamos en android menor a 6 para no buscar los permisos
                return true;
            }

            //validamos si los permisos ya fueron aceptados
            if((getContext().checkSelfPermission(WRITE_EXTERNAL_STORAGE)== PackageManager.PERMISSION_GRANTED)&&getContext().checkSelfPermission(CAMERA)==PackageManager.PERMISSION_GRANTED){
                return true;
            }

            if ((shouldShowRequestPermissionRationale(WRITE_EXTERNAL_STORAGE)||(shouldShowRequestPermissionRationale(CAMERA)))){
                cargarDialogoRecomendacion();
            }else{
                requestPermissions(new String[]{WRITE_EXTERNAL_STORAGE, CAMERA}, MIS_PERMISOS);
            }
            return false;//implementamos el que procesa el evento dependiendo de lo que se defina aqui
        }

        @Override
        public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
            super.onRequestPermissionsResult(requestCode, permissions, grantResults);
            if (requestCode==MIS_PERMISOS){
                if(grantResults.length==2 && grantResults[0]==PackageManager.PERMISSION_GRANTED && grantResults[1]==PackageManager.PERMISSION_GRANTED){//el dos representa los 2 permisos
                    Toast.makeText(getContext(),"Permisos aceptados",Toast.LENGTH_SHORT);
                    btnFoto.setEnabled(true);
                }
            }else{
                solicitarPermisosManual();
            }
        }

        private void solicitarPermisosManual() {
            final CharSequence[] opciones={"si","no"};
            final AlertDialog.Builder alertOpciones=new AlertDialog.Builder(getContext());//estamos en fragment
            alertOpciones.setTitle("¿Desea configurar los permisos de forma manual?");
            alertOpciones.setItems(opciones, new DialogInterface.OnClickListener() {
                @RequiresApi(api = Build.VERSION_CODES.M)
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    if (opciones[i].equals("si")){
                        Intent intent=new Intent();
                        intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
                        Uri uri=Uri.fromParts("package",getContext().getPackageName(),null);
                        intent.setData(uri);
                        startActivity(intent);
                    }else{
                        Toast.makeText(getContext(),"Los permisos no fueron aceptados",Toast.LENGTH_SHORT).show();
                        dialogInterface.dismiss();
                    }
                }
            });
            alertOpciones.show();
        }


        private void cargarDialogoRecomendacion() {
            AlertDialog.Builder dialogo=new AlertDialog.Builder(getContext());
            dialogo.setTitle("Permisos Desactivados");
            dialogo.setMessage("Debe aceptar los permisos para el correcto funcionamiento de la App");

            dialogo.setPositiveButton("Aceptar", new DialogInterface.OnClickListener() {
                @TargetApi(Build.VERSION_CODES.M)
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    requestPermissions(new String[]{WRITE_EXTERNAL_STORAGE,CAMERA},100);
                }
            });
            dialogo.show();
        }


        @RequiresApi(api = Build.VERSION_CODES.M)
        private void cargarWebService() {
            progreso=new ProgressDialog(getContext());
            progreso.setMessage("Cargando...");
            progreso.show();
            String url=ip+"RegistroImagen.php";
            stringRequest=new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {

                @Override
                public void onResponse(String response) {
                    progreso.hide();
                    Toast.makeText(getContext(),"Se ha registrado con exito",Toast.LENGTH_SHORT).show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getContext(),"No se ha podido conectar",Toast.LENGTH_SHORT).show();
                    progreso.hide();
                }
            }){
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    String nombre=campoNombre.getText().toString();
                    String imagen=convertirImgString(bitmap);
                    Map<String,String> parametros=new HashMap<>();
                    parametros.put("nombre",nombre);
                    parametros.put("imagen",imagen);
                    return parametros;
                }
            };
            //request.add(stringRequest);
            stringRequest.setRetryPolicy(new DefaultRetryPolicy(DefaultRetryPolicy.DEFAULT_TIMEOUT_MS * 2, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
            VolleySingleton.getIntanciaVolley(getContext()).addToRequestQueue(stringRequest);
        }

        private String convertirImgString(Bitmap bitmap) {

            ByteArrayOutputStream array=new ByteArrayOutputStream();
            bitmap.compress(Bitmap.CompressFormat.JPEG,100,array);
            byte[] imagenByte=array.toByteArray();
            String imagenString= Base64.encodeToString(imagenByte,Base64.DEFAULT);

            return imagenString;
        }


        // TODO: Rename method, update argument and hook method into UI event
        public void onButtonPressed(Uri uri) {
            if (mListener != null) {
                mListener.onFragmentInteraction(uri);
            }
        }

        @Override
        public void onAttach(Context context) {
            super.onAttach(context);
            if (context instanceof OnFragmentInteractionListener) {
                mListener = (OnFragmentInteractionListener) context;
            } else {
                throw new RuntimeException(context.toString()
                        + " must implement OnFragmentInteractionListener");
            }
        }

        @Override
        public void onDetach() {
            super.onDetach();
            mListener = null;
        }


    /**
         * This interface must be implemented by activities that contain this
         * fragment to allow an interaction in this fragment to be communicated
         * to the activity and potentially other fragments contained in that
         * activity.
         * <p>
         * See the Android Training lesson <a href=
         * "http://developer.android.com/training/basics/fragments/communicating.html"
         * >Communicating with Other Fragments</a> for more information.
         */
        public interface OnFragmentInteractionListener {
            // TODO: Update argument type and name
            void onFragmentInteraction(Uri uri);
        }
    }

