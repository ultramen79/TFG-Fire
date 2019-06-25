package com.example.fire;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v13.app.FragmentCompat;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import static com.example.fire.MainActivity.ip;


public class FragmentRespuestaConsultar extends Fragment implements FragmentCompat.OnRequestPermissionsResultCallback, Response.Listener<JSONObject>, Response.ErrorListener {

    static String TAG_1 = "text";
    static String TAG_2 = "text2";

    String ma, he;
    String nomb="";
    TextView textView1, textView2, textView3;
    ListView listView;
    EditText consulta;
    ProgressDialog progreso;
    List<String> listaherramientas;
    EnviarConsulta infor;

    Button botonRegistro;

    RequestQueue request;
    JsonObjectRequest jsonObjectRequest;

    StringRequest stringRequest;
    private View vie;

    public FragmentRespuestaConsultar() {
        // Required empty public constructor
    }

    public static FragmentRespuestaConsultar newInstance(String text1, String text2) {

        FragmentRespuestaConsultar fragmento2Dinamico = new FragmentRespuestaConsultar();
        Bundle b = new Bundle();
        b.putString(TAG_1,text1);
        b.putString(TAG_2,text2);
        fragmento2Dinamico.setArguments(b);
        return fragmento2Dinamico;

    }

    @Override
    public View onCreateView( LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        vie =getActivity().getLayoutInflater().inflate(R.layout.fragment_respuesta_consultar, container, false);
        textView1= (TextView) vie.findViewById(R.id.textView1);
        textView2= (TextView) vie.findViewById(R.id.textView2);
        textView3= (TextView) vie.findViewById(R.id.textViewCons);

        return vie;
    }


    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        textView1.setText(this.getArguments().getString(TAG_1));
        textView2.setText(this.getArguments().getString(TAG_2));
        cargarWebService();
    }


    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        try{
            infor = (EnviarConsulta) context;
        }
        catch (Exception e){
            Log.v("test", "Error, no se ha podido llevar a cabo la comunicación");
        }
    }

    @Override
    public void onResume() {
        super.onResume();
    }

    @Override
    public void onPause() {
        super.onPause();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
    }

    private void cargarWebService() {
        RequestQueue request;
        request = Volley.newRequestQueue(getContext());
        progreso = new ProgressDialog (getContext());
        progreso.setMessage("Consultando.....");
        progreso.show();

        ma=textView1.getText().toString();
        he=textView2.getText().toString();
        //ma="2222 CCC";
        //he="portatil";
        he= he.trim();
        he= he.toLowerCase();
        String url= ip+"UsadoPor.php?matricula="+ma+"&herramienta="+he;
        url = url.replace(" ","%20");
        jsonObjectRequest = new JsonObjectRequest(Request.Method.GET,url,null,this,this);
        jsonObjectRequest.setRetryPolicy(new DefaultRetryPolicy(DefaultRetryPolicy.DEFAULT_TIMEOUT_MS, 3, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
        request.add(jsonObjectRequest);
    }

    @Override
    public void onErrorResponse(VolleyError error) {
        progreso.hide();
        Toast.makeText(getContext(),"No se pudo consultar" + error.toString(),Toast.LENGTH_SHORT).show();
        Log.i("ERROR ", error.toString());
    }

    @Override
    public void onResponse(JSONObject response) {
        progreso.hide();
        JSONArray json=response.optJSONArray("datos");
        try {

            JSONObject jsonObject=null;
            jsonObject=json.getJSONObject(0);
            nomb=(String) jsonObject.optString("nombre");
            progreso.hide();
            textView3.setText(nomb);
        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(getContext(), "No se ha podido establecer conexión con el servidor" +
                    " "+response, Toast.LENGTH_LONG).show();
            progreso.hide();
        }
    }

    public interface EnviarConsulta {
        public void enviarcons(String text1);
    }

}
