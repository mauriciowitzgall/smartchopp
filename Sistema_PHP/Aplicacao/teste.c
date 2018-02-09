int p = 0;// guarda a posicao inicial da palavra
int cont = 1;
char valor[20];
float qtdmax;
float valuni;

for(int i = 0; i < strlen(payload); i++) {
  if (payload[i] == '|') {
    if(cont == 1) {
      vai=valor;
      valor="";
      cont++;
    }
    if (cont==2) {
      qtdmax=valor;
      valor="";
      cont++;      
    }
    if (cont==3) {
      valuni=valor;
      valor="";           
    }    
  }
  valor=valor+payload[i];
  p = i + 1; // posicao inicial da possivel proxima palavra
}