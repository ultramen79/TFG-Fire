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
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.ScrollView;
import android.widget.Spinner;
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

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import static com.example.fire.MainActivity.ip;


public class FragmentConsultar extends Fragment implements FragmentCompat.OnRequestPermissionsResultCallback, Response.Listener<JSONObject>, Response.ErrorListener {

    static String TAG_1 = "text";

    TextView textView, textView2;
    ListView listView;
    ProgressDialog progreso;
    List<String> listaherramientas;
    EnviarConsulta infor;
    String eleccion;
    Button botonRegistro;

    JsonObjectRequest jsonObjectRequest;

    private View vie;

    public FragmentConsultar() {
        // Required empty public constructor
    }

    public static FragmentConsultar newInstance(String text) {
        FragmentConsultar fragmento2Dinamico = new FragmentConsultar();
        Bundle b = new Bundle();
        b.putString(TAG_1,text);
        fragmento2Dinamico.setArguments(b);
        return fragmento2Dinamico;

    }

    @Override
    public View onCreateView( LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        vie =getActivity().getLayoutInflater().inflate(R.layout.fragment_consultar, container, false);
        textView= (TextView) vie.findViewById(R.id.textView1);
        listView = (ListView) vie.findViewById(R.id.list);
        textView2 = (TextView) vie.findViewById(R.id.textViewCons);
        botonRegistro= (Button) vie.findViewById(R.id.btnConsultar);
        eleccion="Ninguno";
        listaherramientas= new ArrayList<>();
        if (1 > listaherramientas.size()) {
            cargarWebService();
        }
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                eleccion= (String) listView.getItemAtPosition(position);
                Toast.makeText(vie.getContext(),"Has elegido: "+eleccion, Toast.LENGTH_LONG).show();
                infor.enviarcons (textView.getText().toString(),eleccion);

            }
        });
        return vie;
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        textView.setText(this.getArguments().getString(TAG_1));
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
        String url= ip+"ConsultaHerramienta.php";
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
        String matri="";
        JSONArray json=response.optJSONArray("datos");
        try {

            for (int i=0;i<json.length();i++){
                JSONObject jsonObject=null;
                jsonObject=json.getJSONObject(i);
                matri=(String) jsonObject.optString("he_no");
                listaherramientas.add(matri);
            }
            progreso.hide();
            ArrayAdapter adaptor = new ArrayAdapter(this.getContext(),R.layout.list_item_matriculas , listaherramientas);
            listView.setAdapter(adaptor);

        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(getContext(), "No se ha podido establecer conexión con el servidor" +
                    " "+response, Toast.LENGTH_LONG).show();
            progreso.hide();
        }
    }

    public interface EnviarConsulta {
        public void enviarcons(String text1, String text2);
    }
}
