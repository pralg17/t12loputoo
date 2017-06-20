from django.shortcuts import render
from .backend import *
from .forms import InputForm


def index(request):
	# Genereerib tavalise formi HTML's kui formi ei ole saadetud.
	if request.method != "POST":
		form = InputForm()
		return render(request, "website/index.html", {'form': form})

	else:

		# Salvestab enda sisse formiga saadetud andmed ja teeb nendest DataFrame.
		text = request.POST.get("text")
		ngrams = int(request.POST.get('n_gram'))
		maatriks = request.POST.get("maatriks")
		df = make_dataframe(text)
		
		# Kasutades DataFrame'i loob andmed väljanäitamiseks.
		counted_lemmas = count_attribute(df, "lemmas")                      # [['lemma', kogus], ['lemma', kogus]]
		letter_sequence = get_letter_sequence(df, ngrams)                   # [['tähejäriend', kogus], ['tähejäriend', kogus]]
		counted_basewords_lemmas = get_it_all(df)                           # [['põhivorm', 'lemma', põhivormikogus], ['põhivorm', 'lemma', põhivormikogus]]
		adjacency_matrix, headers = get_adjandency_matrix(text, ngrams)     # Annab välja maatriksi ja maatriksi tulpade pealkirjad.

		# Genereerib uuesti formi, mida HTML lehele saata.
		form = InputForm()

		if maatriks == "Ilma maatriksita":
			return render(request, "website/index.html", {'form': form, 'lemmas': counted_lemmas, 'letters': letter_sequence,'word_texts': counted_basewords_lemmas, 'header': headers})
		else:
			return render(request, "website/index.html", {'form': form, 'lemmas': counted_lemmas, 'letters': letter_sequence,'word_texts': counted_basewords_lemmas, 'matrix': adjacency_matrix, 'header': headers})

