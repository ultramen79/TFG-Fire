package com.example.fire;

import android.app.ProgressDialog;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v13.app.FragmentCompat;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import static com.example.fire.MainActivity.ip;

public class FragmentSalida extends Fragment implements FragmentCompat.OnRequestPermissionsResultCallback, Response.Listener<JSONObject>, Response.ErrorListener {

    static String TAG_1 = "text";
    static String TAG_2 = "text1";

    String texto= null;
    View view;
    TextView textView1, textView2;
    String fecha;
    String herram;
    String matri;
    String nombre;
    ProgressDialog progreso;
    EditText campoPersona;
    Button botonRegistro;
    RequestQueue request;
    JsonObjectRequest jsonObjectRequest;
    StringRequest stringRequest;
    private View vie;

    public FragmentSalida() {
        // Required empty public constructor
    }

    public static FragmentSalida newInstance(String text1, String text2) {
        FragmentSalida fragmento2Dinamico = new FragmentSalida();
        Bundle b = new Bundle();
        b.putString(TAG_1,text1);
        b.putString(TAG_2,text2);
        fragmento2Dinamico.setArguments(b);
        return fragmento2Dinamico;
}

    @Override
    public View onCreateView( LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        vie =getActivity().getLayoutInflater().inflate(R.layout.fragment_salida, container, false);

        textView1 = (TextView) vie.findViewById(R.id.textViewSalida1);
        textView2 = (TextView) vie.findViewById(R.id.textViewSalida2);
        campoPersona= (EditText) vie.findViewById(R.id.consulta);
        botonRegistro= (Button) vie.findViewById(R.id.btnConsultar);
        request = Volley.newRequestQueue(getContext());

        botonRegistro.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                cargarWebService();
            }
        });
        return vie;
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        textView1.setText(this.getArguments().getString(TAG_1));
        textView2.setText(this.getArguments().getString(TAG_2));
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
        progreso.setMessage("Cargando.....");
        progreso.show();

        matri=textView1.getText().toString();
        herram=textView2.getText().toString();
        herram= herram.trim();
        herram= herram.toLowerCase();
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy/MM/dd");
        fecha = sdf.format(new Date());
        nombre=campoPersona.getText().toString();
        String url= ip+"RegistroSalida.php?matricula="+matri+"&herramienta="+herram+"&nombre="+nombre+"&fecha="+fecha;
        url = url.replace(" ","%20");
        jsonObjectRequest= new JsonObjectRequest(Request.Method.GET,url,null,this,this);
        request.add(jsonObjectRequest);
    }

    @Override
    public void onErrorResponse(VolleyError error) {
        progreso.hide();
        Toast.makeText(getContext(),"No se pudo registrar la salida" + error.toString(),Toast.LENGTH_SHORT).show();
        Log.i("ERROR ", error.toString());
    }

    @Override
    public void onResponse(JSONObject response) {
        progreso.hide();
        Toast.makeText(getContext()," "+response,Toast.LENGTH_SHORT).show(); progreso.hide();
        campoPersona.setText("");
        herram="";
        nombre="";
        fecha="";
    }
}
