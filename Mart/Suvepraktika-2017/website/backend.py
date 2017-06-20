from estnltk import Text
from collections import Counter
import numpy as np
import pandas as pd


# Eemaldab sisestatud sõnadest arvud, lausemärgid ja nimed.
# Tagastab DataFrame, ei eemaldata duplikaate.
def make_dataframe(text):
	dataframe = Text(text).get(["word_texts", "lemmas", "postag_descriptions", "descriptions"]).as_dataframe
	filtered_dataframe = dataframe[
		(dataframe.postag_descriptions != "lausemärk") & (dataframe.descriptions != "") & (dataframe.lemmas != "") & (
			dataframe.word_texts != "") & (dataframe.postag_descriptions != "") & (
			dataframe.postag_descriptions != "pärisnimi") & dataframe.lemmas.apply(
			lambda sona: sona.islower()) & dataframe.word_texts.apply(
			lambda sona: sona.isalpha()) & dataframe.lemmas.apply(lambda sona: sona.isalpha())]
	return filtered_dataframe


# Loeb üle teksi sees esinevate sõnade sageduse.
# Tehtud eraldi count_attribute'st kuna selle tulemused segatakse kokku get_it_all funktsioonis.
# Väljund kujul [("sõna", kogus),("sõna", kogus),("sõna", kogus)]
def count_basewords(dataframe):
	dataframe = dataframe["word_texts"]
	list_of_attributes = list(dataframe)
	c = Counter(list_of_attributes)
	return c.most_common()


# Segab kokku põhisõnavormid, lemmad ning põhisõnavormide sageduse.
# Tagastab väljundi väljaprintimiseks.
def get_it_all(filtered_dataframe):
	t5 = pd.merge(pd.DataFrame.from_records(count_basewords(filtered_dataframe)), filtered_dataframe, left_on=0,
	              right_on="word_texts")[["word_texts", "lemmas", 1]].drop_duplicates()
	t5.columns = ["word_texts", "lemmas", "countDracula"]
	return t5.to_records()


# Loendab ära mingi atribuudi arve, tagastab kujul [("atribuut", arv), ("atribuut", arv2), (... , ...)]
# Atribuudiks saab panna ainult word_texts, lemmas, postag_descriptions, descriptions, ehk need mis on paika pandud make_dataframe funktsioonis.
def count_attribute(dataframe, attribute):
	dataframe = dataframe[attribute]
	list_of_attributes = dataframe.tolist()
	c = Counter(list_of_attributes)
	return c.most_common()


# Võtab sisse dataframe, muudab listiks, numbri selleks kui suur on tähejäriendid.
def get_letter_sequence(dataframe, n_gram):
	dataframe = dataframe.lemmas
	iterable = list(dataframe.unique())
	temp = []
	for sona in iterable:
		for i in range(len(sona) - n_gram + 1):
			temp.append(sona[i:i + n_gram])
	return Counter(temp).most_common()


# Võtab sisse listi sõnadest ja väljastab iga sõna kohta listi sees nende sees olevad n-grammid.
# ['mina', 'maa', 'elu'] -> [['mi', 'in', 'na'], ['ma', 'aa'], ['el', 'lu']]
def find_ngrams(input_list, n):
	temp = []
	for word in input_list:
		temp.append([word[i:i + n] for i in range(len(word) - n + 1)])
	return temp


def get_adjandency_matrix(text, ngram_size):
	# Filtreerib välja arvud, lausemärgid ja nimed ja tagastab unikaalsed lemmad. [[lemma], [lemma], [lemma]]
	lemma_list = list(make_dataframe(text).lemmas.unique())

	# Muudab sõnad nende vastavate n-grammiks.
	# meie maa elu -> mina maa elu -> [['mi', 'in', 'na'], ['ma', 'aa'], ['el', 'lu']]
	# Sõnad on eraldi listides, kuna muidu loetakse ühe sõna lõppu ja teise sõna algust kui külgnevaks tulevas maatriksis.
	ngram_lemmas = find_ngrams(lemma_list, ngram_size)

	# Võtab sisse listi mille sees on listid, ning muudab need ühedimensionaalseks.
	# [['mi', 'in', 'na'], ['ma', 'aa'], ['el', 'lu']] -> ['mi', 'in', 'na', 'ma', 'aa, ... ]
	pure_ngram = [item for sublist in ngram_lemmas for item in sublist]
	most_common_sequence = Counter(pure_ngram).most_common()

	# Peale most_commonist läbi käimist, jäävav alles ainult unikaalsed tähejäriendid.
	# Need tähejäriendid on sageduse põhjal suuruse järiekorras.
	flatten = [count[0] for count in most_common_sequence]
	flat_len = len(flatten)

	# Loob kahedimensionaalse massiivi kuhu andmeid panna.
	two_dimensional_array = np.zeros(shape=(flat_len, flat_len), dtype='uint16')

	for word in ngram_lemmas:

		# Võtab järiestikku kaks üksteisele järgnevat tähejäriendi n-grammi ning leiab nende indeksid unikaalsete tähejäriendite massiivist.
		for i in range(len(word) - 1):
			index_x = flatten.index(word[i])

			# N-grammi külgnevuse eemaldamiseks võtta välja rida 82.
			# If lause on selleks, et mitte lugeda ainult n-grammi külgnevusi kuid ka reaalsete tähte külgnevusi mingis sõnas.
			# If lause ise on selleks et list indeksist välja ei läheks, hüppab pidevalt üle ühe.
			if i < len(word) - ngram_size: two_dimensional_array[index_x][flatten.index(word[i + ngram_size])] += 1

	# Muutab andmed loetavaks kuujuks.
	value_matrix = pd.DataFrame(two_dimensional_array, index=flatten, columns=flatten).values.tolist()

	return value_matrix, flatten
