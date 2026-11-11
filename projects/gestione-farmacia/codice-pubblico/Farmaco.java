package model;

/**
 * Classe di dominio estratta dal progetto universitario GestioneFarmacia.
 * Nessuna credenziale o dato sanitario di un paziente.
 */
public class Farmaco {
    private String ID;
    private String casaFarmaceutica;
    private String nomeCommerciale;
    private int quantita;
    private double prezzo;
    private String tipo;

    // Attributi per i dettagli della ricetta
    private int numRicetta;
    private String medicoCF;
    private int durataAssunzione;
    private String dataEmissione;
    private String pazienteCF;

    public Farmaco(String ID, String casaFarmaceutica, String nomeCommerciale, int quantita, double prezzo, String tipo) {
        this.ID = ID;
        this.casaFarmaceutica = casaFarmaceutica;
        this.nomeCommerciale = nomeCommerciale;
        this.quantita = quantita;
        this.prezzo = prezzo;
        this.tipo = tipo;
    }

    public String getID() { return ID; }
    public void setID(String ID) { this.ID = ID; }

    public String getCasaFarmaceutica() { return casaFarmaceutica; }
    public void setCasaFarmaceutica(String casaFarmaceutica) { this.casaFarmaceutica = casaFarmaceutica; }

    public String getNomeCommerciale() { return nomeCommerciale; }
    public void setNomeCommerciale(String nomeCommerciale) { this.nomeCommerciale = nomeCommerciale; }

    public int getQuantita() { return quantita; }
    public void setQuantita(int quantita) { this.quantita = quantita; }

    public double getPrezzo() { return prezzo; }
    public void setPrezzo(double prezzo) { this.prezzo = prezzo; }

    public String getTipo() { return tipo; }
    public void setTipo(String tipo) { this.tipo = tipo; }

    public int getNumRicetta() { return numRicetta; }
    public void setNumRicetta(int numRicetta) { this.numRicetta = numRicetta; }

    public String getMedicoCF() { return medicoCF; }
    public void setMedicoCF(String medicoCF) { this.medicoCF = medicoCF; }

    public int getDurataAssunzione() { return durataAssunzione; }
    public void setDurataAssunzione(int durataAssunzione) { this.durataAssunzione = durataAssunzione; }

    public String getDataEmissione() { return dataEmissione; }
    public void setDataEmissione(String dataEmissione) { this.dataEmissione = dataEmissione; }

    public String getPazienteCF() { return pazienteCF; }
    public void setPazienteCF(String pazienteCF) { this.pazienteCF = pazienteCF; }

    @Override
    public String toString() {
        return "Farmaco{" +
                "ID='" + ID + '\'' +
                ", casaFarmaceutica='" + casaFarmaceutica + '\'' +
                ", nomeCommerciale='" + nomeCommerciale + '\'' +
                ", quantita=" + quantita +
                ", prezzo=" + prezzo +
                ", tipo='" + tipo + '\'' +
                ", numRicetta=" + numRicetta +
                ", medicoCF='" + medicoCF + '\'' +
                ", durataAssunzione=" + durataAssunzione +
                ", dataEmissione='" + dataEmissione + '\'' +
                ", pazienteCF='" + pazienteCF + '\'' +
                '}';
    }
}
